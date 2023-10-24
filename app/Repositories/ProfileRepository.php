<?php

namespace App\Repositories;

use App\Models\V1\Talent;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;

class ProfileRepository
{
    use HttpResponses;

    public function updateProfile(array $data)
    {
        $user = Auth::user();

        if(!$user){
            return $this->error('', 401, 'Unauthorized');
        }

        $talent = Talent::where('email', $user->email)->first();

        $talent->update($data);

        return $talent;
    }
}
