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

        if (!$user) {
            return $this->error('', 401, 'Error');
        }

        if ($user->type === 'talent') {
            return $this->handleTalentProfile($user);
        }

        if ($user->type === 'business') {
            return $this->handleBusinessProfile($user);
        }
    }

    private function handleTalentProfile($user)
    {
        $requiredFields = [
            'skill_title',
            'availability',
            'topskills',
            'educations',
            'employments',
            'certificates'
        ];

        $onboarding = $this->checkRequiredFields($user, $requiredFields);
        $port = $user->portfolios->isNotEmpty();

        $details = new TalentResource($user);

        return [
            "status" => 'true',
            "data" => $details,
            'work_details' => $onboarding,
            'portofolio' => $port
        ];
    }

    private function handleBusinessProfile($user)
    {
        $requiredFields = [
            'business_name',
            'location',
            'industry',
            'about_business',
            'website',
            'business_service',
            'business_email'
        ];

        $onboarding = $this->checkRequiredFields($user, $requiredFields);
        $port = !empty($user->company_logo) && !empty($user->company_type) && !empty($user->social_media);

        $details = new BusinessResource($user);

        return [
            "status" => 'true',
            "data" => $details,
            'business_details' => $onboarding,
            'portofolio' => $port
        ];
    }

    private function checkRequiredFields($user, $fields)
    {
        foreach ($fields as $field) {
            if (empty($user->$field)) {
                return false;
            }
        }

        return true;
    }


    public function wallet()
    {
        $user = $this->getUser();
        $talent = Talent::where('id', $user->id)->first();
        $data = $talent->talentwallet->current_bal;
        return $this->success(number_format($data, 2), "Wallet balance", 200);
    }
}
