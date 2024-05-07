<?php

namespace App\Services\Auth;

use App\Events\v1\BusinessWelcomeEvent;
use App\Events\v1\TalentWelcomeEvent;
use App\Http\Resources\V1\LoginUserResource;
use App\Libraries\Utilities;
use App\Mail\v1\BusinessVerifyEmail;
use App\Mail\v1\LoginVerify;
use App\Mail\v1\TalentResendVerifyMail;
use App\Mail\v1\TalentVerifyEmail;
use App\Models\V1\Business;
use App\Models\V1\Talent;
use App\Services\Wallet\CreateService;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    use HttpResponses;

    public function login($request)
    {
        $request->validated($request->all());

        $guards = ['talents' => Talent::class, 'businesses' => Business::class];
        $authenticatedGuard = null;

        foreach ($guards as $guardName => $guardModel) {
            $guard = Auth::guard($guardName);
            if ($guard->attempt($request->only(['email', 'password']))) {
                $authenticatedGuard = $guard;
                break;
            }
        }

        if ($authenticatedGuard) {
            $user = $authenticatedGuard->user();
            if ($user->status !== "active") {
                return $this->error('', 400, 'Account is inactive. Check Email to verify.');
            }

            $userType = strtolower(substr($authenticatedGuard->getProvider()->getModel(), strrpos($authenticatedGuard->getProvider()->getModel(), '\\') + 1));

            if ($userType === 'talent') {
                $user = Talent::with(['portfolios', 'topskills', 'educations', 'employments', 'certificates'])
                    ->where('id', $user->id)
                    ->first();
                return $this->handleUserVerification($user);
            } elseif ($userType === 'business') {
                $business = Business::where('id', $user->id)->first();
                return $this->handleBusinessVerification($business);
            }
        }

        return $this->error('', 401, 'This account does not exist with MySpurr.');
    }

    public function verifyUser($request)
    {
        $user = Talent::with(['portfolios', 'topskills', 'educations', 'employments', 'certificates'])
        ->where('otp', $request->code)
        ->where('otp_expires_at', '>', now())
        ->first();

        $business = Business::where('otp', $request->code)
        ->where('otp_expires_at', '>', now())
        ->first();

        if($user) {
            return $this->handleUserVerification($user);
        } elseif ($business) {
            return $this->handleBusinessVerification($business);
        }else {
            return $this->error(null, 404, "Invalid code");
        }
    }

    public function talentSignup($request)
    {
        $request->validated($request->all());

        try {
            DB::beginTransaction();

            $otpExpiresAt = now()->addMinutes(15);
            $user = Talent::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => 'talent',
                'otp' => Str::random(60),
                'otp_expires_at' => $otpExpiresAt,
                'status' => 'Inactive'
            ]);

            // $wallet_no = Utilities::generateNuban($user->id);
            // (new CreateService($user->id, $wallet_no))->run();
            Mail::to($request->email)->send(new TalentVerifyEmail($user));
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            throw $this->error('error', 400, $e->getMessage());
        }

        return $this->success('', 'Account created successfully');
    }

    public function verifyToken($token)
    {
        $user = Talent::where('otp', $token)
        ->where('otp_expires_at', '>', now())
        ->first();

        if (!$user) {
            if(App::environment('production')){
                $redirect = redirect()->to(config('services.url.false_production_url'));
            }elseif(App::environment('staging')){
                $redirect = redirect()->to(config('services.url.false_staging_url'));
            }
        }

        if($user?->otp == null){
            if(App::environment('production')){
                $redirect = redirect()->to(config('services.url.production_url'));
            }elseif(App::environment('staging')){
                $redirect = redirect()->to(config('services.url.staging_url'));
            }
        }

        if($user){
            return $this->handleUserVerify($user);
        } else {
            if(App::environment('production')){
                $redirect = redirect()->to(config('services.url.false_production_url'));
            }elseif(App::environment('staging')){
                $redirect = redirect()->to(config('services.url.false_staging_url'));
            }
        }

        return $redirect;
    }

    public function businessRegister($request)
    {
        $request->validated($request->all());

        DB::beginTransaction();

        $otpExpiresAt = now()->addMinutes(5);

        $user = Business::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'business_name' => $request->business_name,
            'password' => bcrypt($request->password),
            'type' => 'business',
            'terms' => $request->terms,
            'otp_expires_at' => $otpExpiresAt,
            'otp' => Str::random(60),
            'status' => 'Inactive'
        ]);

        try {
            Mail::to($request->email)->send(new BusinessVerifyEmail($user));

            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return $this->error('error', 400, 'Email sending failed!. Try again');
        }

        return $this->success('', 'Account created successfully');
    }

    public function verifys($token)
    {
        $user = Business::where('otp', $token)
        ->where('otp_expires_at', '>', now())
        ->first();

        if (!$user) {
            if(App::environment('production')){
                $redirect = redirect()->to(config('services.url.false_production_url'));
            }elseif(App::environment('staging')){
                $redirect = redirect()->to(config('services.url.false_staging_url'));
            }
        }

        if($user->otp == ""){
            if(App::environment('production')){
                $redirect = redirect()->to(config('services.url.production_url'));
            }elseif(App::environment('staging')){
                $redirect = redirect()->to(config('services.url.staging_url'));
            }
        }

        if($user){
            return $this->handleBusinessVerify($user);
        } else {
            if(App::environment('production')){
                $redirect = redirect()->to(config('services.url.false_production_url'));
            }elseif(App::environment('staging')){
                $redirect = redirect()->to(config('services.url.false_staging_url'));
            }
        }

        return $redirect;
    }

    public function resendCode($request)
    {
        DB::beginTransaction();

        $otpExpiresAt = now()->addMinutes(5);

        $talent = Talent::where('email', $request->email)
        ->where('status', 'Inactive')
        ->first();

        if(!empty($talent->otp_expires_at) && $talent->otp_expires_at > now()){
            $message = $this->error('', 400, 'Sorry code has been sent try again after some minutes.');

        }elseif($talent){
            $talent->update([
                'otp' => Str::random(60),
                'otp_expires_at' => $otpExpiresAt,
            ]);
            try {
                Mail::to($request->email)->send(new TalentResendVerifyMail($talent));
                DB::commit();
            } catch (\Exception $e){
                DB::rollBack();
                $message = $this->error('error', 400, 'Email sending failed!. Try again');
            }
            $message = $this->success('', 'Verification code sent successfully');

        }else{
            $message = $this->error('error', 400, 'Not Found!');
        }

        return $message;
    }

    public function changePassword($request)
    {
        $user = $request->user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
                'pass_word' => $request->new_password,
            ]);

             return [
                "status" => 'true',
                "message" => 'Password Successfully Updated',
            ];

        }else {
            return $this->error(null, 422, 'Old Password did not match');
        }
    }

    public function resendCodeTwo($request)
    {
        DB::beginTransaction();

        $otpExpiresAt = now()->addMinutes(5);
        $talent = Talent::where('email', $request->email)
        ->first();

        if($talent->otp_expires_at > now()){
            return $this->error('', 400, 'Sorry code has been sent try again after some minutes.');
        }

        if($talent){
            $talent->update([
                'otp' => rand(000000, 999999),
                'otp_expires_at' => $otpExpiresAt,
            ]);

            try {
                Mail::to($request->email)->send(new LoginVerify($talent));
                DB::commit();
            } catch (\Exception $e){
                DB::rollBack();
                throw $this->error('error', 400, 'Email sending failed!. Try again');
            }
            return $this->success('', 'Code sent successfully');

        }else{
            return $this->error('error', 400, 'Not Found!');
        }
    }

    public function logout()
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->success('', 'You have successfully logged out and your token has been deleted');
    }

    // private function handleLogin($guard, $request)
    // {
    //     $user = $guard->user();

    //     if ($user->status === "Inactive" && $user->otp !== "") {
    //         return $this->error('', 400, 'Account is inactive. Check Email to verify.');
    //     }

    //     if ($user->otp_expires_at > now()) {
    //         return $this->error('', 400, 'Sorry code has been sent try again after some minutes.');
    //     }

    //     $otpExpiresAt = now()->addMinutes(10);
    //     $user->update([
    //         'otp' => rand(100000, 999999),
    //         'otp_expires_at' => $otpExpiresAt
    //     ]);

    //     try {
    //         Mail::to($request->email)->send(new LoginVerify($user));
    //     } catch (\Exception $e) {
    //         throw $this->error('error', 500, $e->getMessage());
    //     }

    //     return $this->success(null, "OTP sent to Email Address", 200);
    // }

    private function handleUserVerification($user)
    {
        $portfolios = $user->portfolios;
        $topSkills = $user->topskills;
        $educations = $user->educations;
        $employments = $user->employments;
        $certificates = $user->certificates;

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
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);
        $token = $user->createToken('API Token of ' . $user->first_name);
        $user = new LoginUserResource($user);

        return $this->success([
            'user' => $user,
            'work_details' => $onboarding,
            'portofolio' => $port,
            'token' => $token->plainTextToken
        ]);
    }

    private function handleBusinessVerification($business)
    {
        if (empty($business->business_name) || empty($business->location) || empty($business->industry) || empty($business->about_business) || empty($business->website) || empty($business->business_service) || empty($business->business_email)) {
            $onboarding = false;
        } else {
            $onboarding = true;
        }

        if (empty($business->company_logo) || empty($business->company_type) || empty($business->social_media)) {
            $port = false;
        } else {
            $port = true;
        }

        $token = $business->createToken('API Token of ' . $business->first_name);
        $user = new LoginUserResource($business);

        $business->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return $this->success([
            'user' => $user,
            'business_details' => $onboarding,
            'portofolio' => $port,
            'token' => $token->plainTextToken
        ]);
    }

    private function handleUserVerify($user)
    {
        $user->status = 'active';
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        try {
            event(new TalentWelcomeEvent($user));
            if (App::environment('production')) {
                return redirect()->to(config('services.url.verify_production_url'));
            } elseif (App::environment('staging')) {
                return redirect()->to(config('services.url.verify_staging_url'));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('error', 400, 'Email sending failed!. Try again');
        }
    }

    private function handleBusinessVerify($user)
    {
        $user->status = 'active';
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        try {
            event(new BusinessWelcomeEvent($user));
            if (App::environment('production')) {
                return redirect()->to(config('services.url.verify_production_url'));
            } elseif (App::environment('staging')) {
                return redirect()->to(config('services.url.verify_staging_url'));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('error', 400, 'Email sending failed!. Try again');
        }
    }
}
