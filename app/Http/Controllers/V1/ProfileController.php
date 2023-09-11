<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BusinessResource;
use App\Http\Resources\V1\LoginUserResource;
use App\Http\Resources\V1\TalentResource;
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

            $details = new TalentResource($user);

            return [
                "status" => 'true',
                "data" => $details
            ];

        }

        if($user->type === 'business'){

            $details = new BusinessResource($user);

            return [
                "status" => 'true',
                "data" => $details
            ];

        }

    }
}
