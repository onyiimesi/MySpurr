<?php

namespace App\Traits;

use App\Models\Admin\Admin;
use App\Models\V1\Talent;
use App\Models\V1\Business;

trait MessageTrait
{
    public function determineReceiverType($email)
    {
        if (Talent::where('email', $email)->exists()) {
            return Talent::class;
        }

        if (Business::where('email', $email)->exists()) {
            return Business::class;
        }

        if (Admin::where('email', $email)->exists()) {
            return Admin::class;
        }

        return null;
    }

    public function findReceiver($email, $receiverType)
    {
        return $receiverType::where('email', $email)->first();
    }

    public function determineSenderType()
    {
        $user = auth()->user();

        if ($user instanceof Business) {
            return Business::class;
        }

        if ($user instanceof Admin) {
            return Admin::class;
        }

        return Talent::class;
    }
}



