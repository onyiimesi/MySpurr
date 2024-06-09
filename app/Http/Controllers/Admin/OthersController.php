<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\Business;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class OthersController extends Controller
{
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

    public function businessForgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $business = Business::where('email', $request->email)->first();

        if (!$business) {
            return $this->error('error', 404, 'We can\'t find a business with that email address');
        }

        $status = Password::broker('business')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }
}
