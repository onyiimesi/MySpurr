<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BusinessDetailsRequest;
use App\Http\Requests\V1\BusinessPortfolioRequest;
use App\Http\Resources\V1\BusinessDetailsResource;
use App\Http\Resources\V1\BusinessPortfolioResource;
use App\Models\V1\Business;
use App\Services\Business\BusinessService;
use App\Services\CountryState\CountryDetailsService;
use App\Services\CountryState\StateDetailsService;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

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
}
