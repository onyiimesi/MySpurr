<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BusinessDetailsRequest;
use App\Services\Business\BusinessService;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class BusinessOnboardingController extends Controller
{
    use HttpResponses;

    protected $service;

    public function __construct(BusinessService $businessService)
    {
        $this->service = $businessService;
    }

    public function businessDetails(BusinessDetailsRequest $request)
    {
        return $this->service->businessDetails($request);
    }

    public function editProfile(Request $request)
    {
        return $this->service->editProfile($request);
    }

    public function listBusiness()
    {
        return $this->service->listBusiness();
    }

    public function businessUUID($uuid)
    {
        return $this->service->businessUUID($uuid);
    }
}
