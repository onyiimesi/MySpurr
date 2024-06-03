<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\AdminLoginResource;
use App\Models\Admin\Admin;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    use HttpResponses;

    public function addUser($request)
    {
        try {

            Admin::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => bcrypt('12345678'),
                'is_active' => "1",
                'status' => "1"
            ]);

            return $this->success(null, "Added successfully", 201);

        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function authLogin($request)
    {
        $authGuard = Auth::guard('admins');

        if ($authGuard->attempt($request->only(['email', 'password']))) {
            $auth = Auth::guard('admins')->user();

            if($auth->is_active === 0){
                return $this->error('', 'Account is inactive, contact support', 400);
            }

            if($auth->status === 0){
                return $this->error('', 'Account is not verified, check email', 400);
            }

            $user = Admin::where('email', $request->email)->first();
            $token = $user->createToken('API Token of '. $user->email);

            return $this->success([
                'is_active' => (int)$user->is_active,
                'status' => (int)$user->status,
                'token' => $token->plainTextToken
            ]);
        }

        return $this->error('', 401, 'Credentials do not match');
    }
}



