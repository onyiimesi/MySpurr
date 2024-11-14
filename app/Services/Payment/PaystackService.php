<?php

namespace App\Services\Payment;

use App\Enum\JobChargeType;
use App\Models\V1\Payment;
use App\Enum\PaymentOption;
use App\Enum\PaystackEvent;
use App\Enum\TalentJobStatus;
use App\Http\Resources\V1\PaymentVerifyResource;
use App\Models\V1\Business;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use App\Mail\v1\JobPaymentInvoiceMail;
use App\Models\V1\JobCharge;
use App\Models\V1\Question;
use App\Models\V1\TalentJob;
use App\Services\Curl\GetCurlService;
use Illuminate\Support\Facades\DB;
use App\Services\Job\CreateJobService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackService
{
    use HttpResponses;

    public function processPayment($request)
    {
        $job = $request->input('job');
        
        $type = JobChargeType::SINGLE_HIRING;
        $charge = JobCharge::where('slug', $type)->first();

        if($charge) {
            $percent = $charge->percentage;
        } else {
            $percent = 15;
        }

        $percentInDecimal = $percent / 100;
        $totAmount = $percentInDecimal * $job['salary_min'];

        $vatPercent = 7.5;
        $vatInDecimal = $vatPercent / 100;
        $vatAmount = $totAmount * $vatInDecimal;

        $amount = $totAmount + $vatAmount;
        $status = 1;

        // if($request->is_highlighted == 1){
        //     $amount = $totAmount + $this->highlight;
        //     $status = 1;
        // }else{
        //     $amount = $totAmount;
        //     $status = 0;
        // }

        $callbackUrl = $request->input('payment_redirect_url');
        if (!filter_var($callbackUrl, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid callback URL'], 400);
        }

        $paymentDetails = [
            'email' => $request->email,
            'amount' => $amount * 100,
            "currency" => "NGN",
            'metadata' => json_encode([
                'business_id' => $request->business_id,
                'payment_portal_url' => config('services.paystack_payment_url'),
                'type' => $request->type,
                'payment_option' => $request->payment_option,
                'job' => $request->input('job'),
                'is_highlighted' => $status,
                'vat' => $vatAmount,
                'main_amount' => $totAmount,
                'job_id' => 0,
            ]),
            'callback_url' => $request->input('payment_redirect_url'),
        ];

        $paystackInstance = Paystack::getAuthorizationUrl($paymentDetails);

        switch ($request->payment_option) {
            case PaymentOption::ONLINE:
                return response()->json($paystackInstance);
                break;
            case PaymentOption::INVOICE:

                $job = $this->createJob($request);

                if($job) {
                    $paymentDetails = [
                        'email' => $request->email,
                        'amount' => $amount * 100,
                        "currency" => "NGN",
                        'metadata' => json_encode([
                            'business_id' => $request->business_id,
                            'job_id' => $job->id,
                            'payment_portal_url' => config('services.paystack_payment_url'),
                            'job' => $job,
                            'is_highlighted' => 1,
                            'type' => $request->type,
                            'payment_option' => PaymentOption::INVOICE,
                            'vat' => $vatAmount,
                            'main_amount' => $totAmount,
                        ]),
                        'callback_url' => $request->input('payment_redirect_url'),
                    ];

                    $paystackInstance = Paystack::getAuthorizationUrl($paymentDetails);
                    $url = $paystackInstance->url;

                    $cost = (object)[
                        'amount' => $amount,
                        'totalAmount' => $totAmount,
                        'vat' => $vatAmount,
                    ];
                }

                return $this->invoicePayment($url, $request, $job, $cost);
                break;
            default:
                return $this->error(null, 'Invalid option!');
                break;
        }
    }

    public function webhook($request)
    {
        $secretKey = config('paystack.secretKey');
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        if (!$signature || $signature !== hash_hmac('sha512', $payload, $secretKey)) {
            return $this->error(null, 'Invalid signature', 400);
        }

        $event = json_decode($payload, true);

        if (isset($event['event']) && $event['event'] === PaystackEvent::CHARGE_SUCCESS) {
            $data = $event['data'];

            if (Payment::where('reference', $data['reference'])->exists()) {
                Log::warning('Payment already processed', ['reference' => $data['reference']]);
                return response()->json(['status' => 'Payment already processed'], 200);
            }

            $this->storePayment($data, $event['event']);
        }

        return response()->json(['status' => true], 200);
    }

    public function verifyPayment($userId, $ref)
    {
        $currentUserId = Auth::id();

        if ($currentUserId != $userId) {
            return $this->error(null, 401, "Unauthorized action.");
        }

        if (!preg_match('/^[A-Za-z0-9]{10,30}$/', $ref)) {
            return $this->error(null, 400, "Invalid payment reference.");
        }

        Business::findOrFail($userId);

        $verify = (new GetCurlService($ref))->run();
        $data = new PaymentVerifyResource($verify);

        return $this->success($data, "Payment verify status");
    }

    private function storePayment($data, $status)
    {
        $ref = $data['reference'];
        $amount = $data['amount'];
        $formattedAmount = number_format($amount / 100, 2, '.', '');
        $channel = $data['channel'];
        $currency = $data['currency'];
        $ip_address = $data['ip_address'];
        $paid_at = $data['paid_at'];
        $createdAt = $data['created_at'];
        $transaction_date = $data['paid_at'];

        $business_id = $data['metadata']['business_id'];
        $payment_portal_url = $data['metadata']['payment_portal_url'];
        $job = $data['metadata']['job'];
        $highlight = $data['metadata']['is_highlighted'];
        $email = $data['customer']['email'];
        $type = $data['metadata']['type'];
        $payment_option = $data['metadata']['payment_option'];
        $main_amount = $data['metadata']['main_amount'];
        $vat = $data['metadata']['vat'];
        $job_id = $data['metadata']['job_id'];

        $business = Business::findOrFail($business_id);

        try {

            DB::beginTransaction();

            $payment = new Payment();
            $payment->business_id = $business_id;
            $payment->first_name = $business->first_name;
            $payment->last_name = $business->last_name;
            $payment->phone_number = $business->phone_number;
            $payment->email = $email;
            $payment->amount = $main_amount;
            $payment->vat = $vat;
            $payment->total_amount = $formattedAmount;
            $payment->reference = $ref;
            $payment->channel = $channel;
            $payment->currency = $currency;
            $payment->ip_address = $ip_address;
            $payment->payment_portal_url = $payment_portal_url;
            $payment->paid_at = $paid_at;
            $payment->createdAt = $createdAt;
            $payment->transaction_date = $transaction_date;
            $payment->status = $status;
            $payment->save();

            DB::commit();
        }catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        if($status === PaystackEvent::CHARGE_SUCCESS){
            (new CreateJobService($job, $email, $highlight, $type, $payment, $payment_option, $job_id))->run();
        }
    }

    private function createJob($request)
    {
        $slug = Str::slug($request->job['job_title']);

        if (TalentJob::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }

        $job = TalentJob::create([
            'business_id' => $request->business_id,
            'job_title' => $request->job['job_title'],
            'slug' => $slug,
            'country_id' => $request->job['country_id'],
            'state_id' => $request->job['state_id'],
            'job_type' => $request->job['job_type'],
            'description' => $request->job['description'],
            'responsibilities' => $request->job['responsibilities'],
            'required_skills' => $request->job['required_skills'],
            'benefits' => $request->job['benefits'],
            'salaray_type' => $request->job['salaray_type'],
            'salary_min' => $request->job['salary_min'],
            'salary_max' => $request->job['salary_max'],
            'currency' => $request->job['currency'],
            'skills' => $request->job['skills'],
            'experience' => $request->job['experience'],
            'qualification' => $request->job['qualification'],
            'status' => TalentJobStatus::PENDING,
        ]);


        if (! empty($request->job['questions'])) {
            foreach ($request->job['questions'] as $questionData) {
                $question = new Question($questionData);
                $job->questions()->save($question);
            }
        }

        return $job;
    }

    private function invoicePayment($paymentLink, $request, $job, $cost)
    {
        $business = Business::findOrFail($request->business_id);
        $payment = (object)[
            'reference' => Str::random(20),
            'total_amount' => $cost->totalAmount,
            'amount' => $cost->amount,
            'vat' => $cost->vat,
            'created_at' => $job->created_at,
        ];

        sendMail($request->email, new JobPaymentInvoiceMail($business, $payment, $job, $paymentLink));

        return $this->success(null, 'Invoice sent successful!');
    }
}


