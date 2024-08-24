<?php

namespace App\Services\Payment;

use App\Enum\Amount;
use App\Enum\TalentJobType;
use App\Models\V1\Payment;
use App\Services\Job\CreateJobService;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use Unicodeveloper\Paystack\Facades\Paystack;


class PaystackService
{
    use HttpResponses;

    public function processPayment($request)
    {
        $job = $request->input('job');

        $percent = 15;
        $percentInDecimal = $percent / 100;
        $totAmount = $percentInDecimal * $job['salary_min'];

        $amount = $totAmount;
        $status = 1;

        // if($request->is_highlighted == 1){
        //     $amount = $totAmount + $this->highlight;
        //     $status = 1;
        // }else{
        //     $amount = $totAmount;
        //     $status = 0;
        // }
        
        $paymentDetails = [
            'email' => $request->email,
            'amount' => $amount * 100,
            "currency" => "NGN",
            'metadata' => json_encode([
                'business_id' => $request->business_id,
                'payment_portal_url' => config('services.paystack_payment_url'),
                'payment_redirect_url' => $request->input('payment_redirect_url'),
                'type' => $request->type,
                'job' => $request->input('job'),
                'is_highlighted' => $status
            ]),
        ];

        $paystackInstance = Paystack::getAuthorizationUrl($paymentDetails);

        return response()->json($paystackInstance);
    }

    public function callback()
    {
        $paymentDetails = Paystack::getPaymentData();

        $data = $paymentDetails['data'];

        $ref = $data['reference'];
        $amount = $data['amount'];
        $formattedAmount = number_format($amount / 100, 2, '.', '');
        $channel = $data['channel'];
        $currency = $data['currency'];
        $ip_address = $data['ip_address'];
        $paid_at = $data['paid_at'];
        $createdAt = $data['createdAt'];
        $transaction_date = $data['transaction_date'];
        $status = $data['status'];

        $redirectURL = $paymentDetails['data']['metadata']['payment_redirect_url'];
        $business_id = $paymentDetails['data']['metadata']['business_id'];
        $payment_portal_url = $paymentDetails['data']['metadata']['payment_portal_url'];
        $job = $paymentDetails['data']['metadata']['job'];
        $highlight = $paymentDetails['data']['metadata']['is_highlighted'];
        $email = $paymentDetails['data']['customer']['email'];
        $type = $paymentDetails['data']['metadata']['type'];

        try {
            DB::transaction(function ()
                use(
                    $business_id,
                    $email,
                    $formattedAmount,
                    $ref,
                    $channel,
                    $currency,
                    $ip_address,
                    $payment_portal_url,
                    $paid_at,
                    $createdAt,
                    $transaction_date,
                    $status
                    ) {

                $payment = new Payment();
                $payment->business_id = $business_id;
                $payment->email = $email;
                $payment->amount = $formattedAmount;
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
            });

        }catch (\Throwable $th) {
            throw $th;
        }

        if($status == "success"){
            (new CreateJobService($job, $email, $highlight, $type))->run();
        }

        $redirectURLs = "";

        if ($paymentDetails) {
            return redirect()->to($redirectURL);
        } else {
            return redirect()->to($redirectURLs);
        }
    }
}


