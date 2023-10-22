<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BusinessResource;
use App\Http\Resources\V1\LoginUserResource;
use App\Http\Resources\V1\TalentResource;
use App\Models\V1\Talent;
use App\Models\V1\TalentPortfolio;
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

        $portfolios = $user->portfolios;
        $topSkills = $user->topskills;
        $educations = $user->educations;
        $employments = $user->employments;
        $certificates = $user->certificates;

        if($user->type === 'talent'){

            if (!empty($user->skill_title) && $topSkills->isNotEmpty() && $educations->isNotEmpty() &&$employments->isNotEmpty() && $certificates->isNotEmpty() && !empty($user->availability)) {
                $onboarding = true;
            } else {
                $onboarding = false;
            }

            if ($portfolios->isNotEmpty()) {
                $port = true;
            } else {
                $port = false;
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
