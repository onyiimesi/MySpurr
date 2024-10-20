<?php

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProcessPaymentRequest;
use App\Services\Payment\PaystackService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use HttpResponses;

    protected $service;

    public function __construct(PaystackService $service){
        $this->service = $service;
    }

    public function processPayment(ProcessPaymentRequest $request)
    {
        return $this->service->processPayment($request);
    }

    public function verifyPayment($userId, $ref)
    {
        return $this->service->verifyPayment($userId, $ref);
    }


}
