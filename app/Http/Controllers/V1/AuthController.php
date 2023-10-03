<?php

namespace App\Http\Controllers\V1;

use App\Events\v1\TalentWelcomeEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreBusinessRequest;
use App\Http\Requests\V1\StoreTalentRequest;
use App\Http\Resources\V1\LoginUserResource;
use App\Mail\V1\BusinessVerifyEmail;
use App\Mail\V1\TalentVerifyEmail;
use App\Mail\v1\TalentWelcomeMail;
use App\Models\V1\Business;
use App\Models\V1\Talent;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {

        $request->validated($request->all());

        $talentGuard = Auth::guard('talents');
        $businessGuard = Auth::guard('businesses');

        if ($talentGuard->attempt($request->only(['email', 'password']))) {
            $user = Talent::where('email', $request->email)->first();

            if (empty($user->skill_title) || empty($user->topskills) || empty($user->highest_education) || empty($user->year_obtained) || empty($user->work_history) || empty($user->certificate_earned) || empty($user->availability)) {
                $onboarding = false;
            } else {
                $onboarding = true;
            }

            if (empty($user->compensation) || empty($user->portfolio_title) || empty($user->portfolio_description) || empty($user->image)) {
                $port = false;
            } else {
                $port = true;
            }

            $token = $user->createToken('API Token of ' . $user->first_name);
            $user = new LoginUserResource($user);

            return $this->success([
                'user' => $user,
                'work_details' => $onboarding,
                'portofolio' => $port,
                'token' => $token->plainTextToken
            ]);

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

    public function talentRegister(StoreTalentRequest $request)
    {

        $request->validated($request->all());

        DB::beginTransaction();

        $user = Talent::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'talent',
            'otp' => Str::random(60),
            'status' => 'Inactive'
        ]);

        try {

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
        $user = Talent::where('otp', $token)->first();

        if (!$user) {
            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login');
        }

        $user->status = 'Active';
        $user->otp = null;
        $user->save();

        try {

            // Mail::to($user->email)->send(new TalentWelcomeMail());
            event(new TalentWelcomeEvent($user->email));

            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?verification=true');

            DB::commit();

        } catch (\Exception $e){
            DB::rollBack();
            return $this->error('error', 400, 'Email sending failed!. Try again');
        }

    }

    public function businessRegister(StoreBusinessRequest $request)
    {

        $request->validated($request->all());

        DB::beginTransaction();

        $user = Business::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'business',
            'terms' => $request->terms,
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
        $user = Business::where('otp', $token)->first();

        if (!$user) {
            return $this->error('', 'Error', 422);
        }

        $user->status = 'Active';
        $user->otp = null;
        $user->save();

        return [
            "status" => 'true',
            "message" => 'Verification successful'
        ];
    }

    public function logout()
    {

        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        // Auth::user()->currentAccessToken()->delete();

        return $this->success('', 'You have successfully logged out and your token has been deleted');
    }
}
