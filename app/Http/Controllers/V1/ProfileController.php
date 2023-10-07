<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BusinessResource;
use App\Http\Resources\V1\LoginUserResource;
use App\Http\Resources\V1\TalentResource;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;

class ProfileController extends Controller
{
    use HttpResponses;

    public function profile()
    {
        $user = Auth::user();

        if(!$user){
            return $this->error('', 401, 'Error');
        }

        if($user->type === 'talent'){

            if (empty($user->skill_title) || empty($user->topskills) || empty($user->educations) || empty($user->employments) || empty($user->certificates) || empty($user->availability)) {
                $onboarding = false;
            } else {
                $onboarding = true;
            }

            if (empty($user->compensation) || empty($user->portfolio_title) || empty($user->portfolio_description) || empty($user->image)) {
                $port = false;
            } else {
                $port = true;
            }

            $details = new TalentResource($user);

            return [
                "status" => 'true',
                "data" => $details,
                'work_details' => $onboarding,
                'portofolio' => $port
            ];

        }

        if($user->type === 'business'){

            if (empty($user->business_name) || empty($user->location) || empty($user->industry) || empty($user->about_business) || empty($user->website) || empty($user->business_service) || empty($user->business_email)) {
                $onboarding = false;
            } else {
                $onboarding = true;
            }

            if (empty($user->company_logo) || empty($user->company_type) || empty($user->social_media)) {
                $port = false;
            } else {
                $port = true;
            }

            $details = new BusinessResource($user);

            return [
                "status" => 'true',
                "data" => $details,
                'business_details' => $onboarding,
                'portofolio' => $port
            ];

        }

    }
}
