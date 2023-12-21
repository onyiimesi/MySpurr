<?php

namespace App\Http\Controllers\V1;

use App\Events\v1\BusinessWelcomeEvent;
use App\Events\v1\TalentWelcomeEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreBusinessRequest;
use App\Http\Requests\V1\StoreTalentRequest;
use App\Http\Resources\V1\LoginUserResource;
use App\Libraries\Utilities;
use App\Mail\V1\BusinessVerifyEmail;
use App\Mail\V1\LoginVerify;
use App\Mail\v1\TalentResendVerifyMail;
use App\Mail\V1\TalentVerifyEmail;
use App\Models\V1\Business;
use App\Models\V1\Talent;
use App\Traits\HttpResponses;
use App\Services\Wallet\CreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        // $this->middleware('throttle:1,5')->only(['login']);
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        $talentGuard = Auth::guard('talents');
        $businessGuard = Auth::guard('businesses');

        if ($talentGuard->attempt($request->only(['email', 'password']))) {
            $user = Talent::where('email', $request->email)->first();

            if($user->status === "Inactive" && $user->otp !== ""){
                return $this->error('', 400, 'Account is inactive. Check Email to verify.');
            }

            if($user->otp_expires_at > now()){
                return $this->error('', 400, 'Sorry code has been sent try again after some minutes.');
            }

            $otpExpiresAt = now()->addMinutes(5);
            $user->update([
                'otp' => mt_rand(00000, 99999),
                'otp_expires_at' => $otpExpiresAt
            ]);

            try {
                Mail::to($request->email)->send(new LoginVerify($user));
            } catch (\Exception $e){
                return $this->error('error', 400, 'Email sending failed!. Try again');
            }
            return $this->success(null, "OTP sent to Email Address", 200);

        } elseif ($businessGuard->attempt($request->only(['email', 'password']))) {
            $stud = Business::where('email', $request->email)->first();

            if (empty($stud->business_name) || empty($stud->location) || empty($stud->industry) || empty($stud->about_business) || empty($stud->website) || empty($stud->business_service) || empty($stud->business_email)) {
                $onboarding = false;
            } else {
                $onboarding = true;
            }

            if (empty($stud->company_logo) || empty($stud->company_type) || empty($stud->social_media)) {
                $port = false;
            } else {
                $port = true;
            }

            $token = $stud->createToken('API Token of ' . $stud->first_name);
            $user = new LoginUserResource($stud);

            return $this->success([
                'user' => $user,
                'business_details' => $onboarding,
                'portofolio' => $port,
                'token' => $token->plainTextToken
            ]);
        }

        return $this->error('', 401, 'Credentials do not match',);
    }

    public function verifyuser(Request $request)
    {
        $user = Talent::where('otp', $request->code)
        ->where('otp_expires_at', '>', now())
        ->first();

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

        $token = $user->createToken('API Token of ' . $user->first_name);
        $user = new LoginUserResource($user);

        return $this->success([
            'user' => $user,
            'work_details' => $onboarding,
            'portofolio' => $port,
            'token' => $token->plainTextToken
        ]);
    }

    public function talentRegister(StoreTalentRequest $request)
    {

        $request->validated($request->all());

        try {
            DB::beginTransaction();

            $otpExpiresAt = now()->addMinutes(5);
            $user = Talent::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'talent',
                'otp' => Str::random(60),
                'otp_expires_at' => $otpExpiresAt,
                'status' => 'Inactive'
            ]);

            $wallet_no = Utilities::generateNuban($user->id);
            (new CreateService($user->id, $wallet_no))->run();
            Mail::to($request->email)->send(new TalentVerifyEmail($user));
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return $this->error('error', 400, 'Email sending failed!. Try again');
        }
        return $this->success('', 'Account created successfully');
    }

    public function verify($token)
    {
        $user = Talent::where('otp', $token)
        ->where('otp_expires_at', '>', now())
        ->first();

        if (!$user) {
            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?verification=false');
        }

        if($user->otp == ""){
            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login');
        }

        if($user){
            $user->status = 'active';
            $user->otp = null;
            $user->otp_expires_at = NULL;
            $user->save();

            try {
                event(new TalentWelcomeEvent($user));
                return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?verification=true');

                DB::commit();
            } catch (\Exception $e){
                DB::rollBack();
                return $this->error('error', 400, 'Email sending failed!. Try again');
            }

        } else {
            // return $this->error('error', 400, 'OTP is invalid or expired');
            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?verification=false');
        }

    }

    public function businessRegister(StoreBusinessRequest $request)
    {

        $request->validated($request->all());

        DB::beginTransaction();

        $otpExpiresAt = now()->addMinutes(5);

        $user = Business::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'business_name' => $request->business_name,
            'password' => Hash::make($request->password),
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
            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?verification=false');
        }

        if($user->otp == ""){
            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login');
        }

        if($user){

            $user->status = 'active';
            $user->otp = null;
            $user->otp_expires_at = NULL;
            $user->save();

            try {

                event(new BusinessWelcomeEvent($user));

                return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?verification=true');

                DB::commit();

            } catch (\Exception $e){
                DB::rollBack();
                return $this->error('error', 400, 'Email sending failed!. Try again');
            }

        } else {
            // return $this->error('error', 400, 'OTP is invalid or expired');
            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?verification=false');
        }
    }

    public function logout()
    {

        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        // Auth::user()->currentAccessToken()->delete();
        return $this->success('', 'You have successfully logged out and your token has been deleted');
    }

    public function resend(Request $request)
    {

        $request->validate([
            'email' => 'required'
        ]);

        DB::beginTransaction();

        $otpExpiresAt = now()->addMinutes(5);

        $talent = Talent::where('email', $request->email)
        ->where('status', 'Inactive')
        ->first();

        if($talent){

            $talent->update([
                'otp' => Str::random(60),
                'otp_expires_at' => $otpExpiresAt,
            ]);

            try {
                Mail::to($request->email)->send(new TalentResendVerifyMail($talent));
                DB::commit();
            } catch (\Exception $e){
                DB::rollBack();
                return $this->error('error', 400, 'Email sending failed!. Try again');
            }
            return $this->success('', 'Verification code sent successfully');

        }else{
            return $this->error('error', 400, 'Not Found!');
        }
    }

    public function change(Request $request){

        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:new_password']
        ]);

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
        }else
        {
            return $this->error(null, 422, 'Old Password did not match');
        }

    }
}
