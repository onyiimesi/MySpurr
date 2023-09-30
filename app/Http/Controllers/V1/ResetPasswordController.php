<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required|string',
        ]);
    
        $talent = Talent::where('email', $request->email)->first();
    
        if (!$talent) {
            return $this->error('error', 404, 'We can\'t find a talent with that email address');
        }
    
        $status = Password::broker('talent')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );
    
        return $status == Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }

}
