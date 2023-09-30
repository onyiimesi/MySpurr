<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Traits\HttpResponses;

class ForgotPasswordController extends Controller
{
    use HttpResponses;

    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $talent = Talent::where('email', $request->email)->first();

        if (!$talent) {
            return $this->error('error', 404, 'We can\'t find a talent with that email address');
        }

        $status = Password::broker('talent')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }
}
