<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreBusinessRequest;
use App\Http\Requests\V1\StoreTalentRequest;
use App\Services\Auth\AuthService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use HttpResponses;

    public $data;

    public function __construct(AuthService $service)
    {
        $this->middleware('throttle:5,1')->only(['login', 'verifyuser']);
        $this->data = $service;
    }

    public function login(LoginUserRequest $request)
    {
        return $this->data->login($request);
    }

    public function verifyuser(Request $request)
    {
        return $this->data->verifyUser($request);
    }

    public function talentRegister(StoreTalentRequest $request)
    {
        return $this->data->talentSignup($request);
    }

    public function verify($token)
    {
        return $this->data->verifyToken($token);
    }

    public function businessRegister(StoreBusinessRequest $request)
    {
        return $this->data->businessRegister($request);
    }

    public function verifys($token)
    {
        return $this->data->verifys($token);
    }

    public function logout()
    {
        return $this->data->logout();
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        return $this->data->resendCode($request);
    }

    public function change(Request $request){

        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:new_password']
        ]);

        return $this->data->changePassword($request);
    }

    public function resendcode(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        return $this->data->resendCodeTwo($request);
    }
}
