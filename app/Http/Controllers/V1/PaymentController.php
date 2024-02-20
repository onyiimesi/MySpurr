<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'business_id' => 'required|numeric',
            'email' => 'required|email|string',
            'amount' => 'required',
            'payment_redirect_url' => 'required'
        ]);

        $paymentDetails = [
            'email' => $request->email,
            'amount' => $request->input('amount') * 100,
            "currency" => "NGN",
            'metadata' => json_encode([
                'business_id' => $request->business_id,
                'payment_portal_url' => env('PAYSTACK_PAYMENT_URL'),
                'payment_redirect_url' => $request->input('payment_redirect_url')
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
        $email = $paymentDetails['data']['customer']['email'];

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

        $redirectURLs = "";

        if ($paymentDetails) {
            return redirect()->to($redirectURL);
        } else {
            return redirect()->to($redirectURLs);
        }
    }
}
