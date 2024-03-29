<?php

namespace App\Http\Controllers\V1;

use App\Enum\Amount;
use App\Http\Controllers\Controller;
use App\Models\V1\Payment;
use App\Services\Job\CreateJobService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    use HttpResponses;

    protected $amount;
    protected $highlight;

    public function __construct(){
        $this->amount = Amount::MAIN_AMOUNT;
        $this->highlight = Amount::HIGHLIGHT_AMOUNT;
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'business_id' => 'required|numeric',
            'email' => 'required|email|string',
            'payment_redirect_url' => 'required',
            'job' => 'required',
            'is_highlighted' => 'required|in:0,1'
        ]);

        if($request->is_highlighted == 1){
            $amount = $this->amount + $this->highlight;
            $status = 1;
        }else{
            $amount = $this->amount;
            $status = 0;
        }

        $paymentDetails = [
            'email' => $request->email,
            'amount' => $amount * 100,
            "currency" => "NGN",
            'metadata' => json_encode([
                'business_id' => $request->business_id,
                'payment_portal_url' => env('PAYSTACK_PAYMENT_URL'),
                'payment_redirect_url' => $request->input('payment_redirect_url'),
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

        // dd($paymentDetails);
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

        }catch (\Throwable $e) {
            return $this->error(null, 400, $e->getMessage());
        }

        if($status == "success"){
            (new CreateJobService($job, $email, $highlight))->run();
        }

        $redirectURLs = "";

        if ($paymentDetails) {
            return redirect()->to($redirectURL);
        } else {
            return redirect()->to($redirectURLs);
        }
    }
}
