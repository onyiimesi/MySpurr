<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreBusinessRequest;
use App\Http\Requests\V1\StoreTalentRequest;
use App\Http\Resources\V1\LoginUserResource;
use App\Mail\V1\BusinessVerifyEmail;
use App\Mail\V1\TalentVerifyEmail;
use App\Models\V1\Business;
use App\Models\V1\Talent;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {

        $request->validated($request->all());

        $talentGuard = Auth::guard('talents');
        $businessGuard = Auth::guard('businesses');

        if ($talentGuard->attempt($request->only(['email_address', 'password']))) {
            $user = Talent::where('email_address', $request->email_address)->first();

            if (empty($user->skill_title) || empty($user->top_skills) || empty($user->highest_education) || empty($user->year_obtained) || empty($user->work_history) || empty($user->certificate_earned) || empty($user->availability)) {
                $onboarding = false;
            } else {
                $onboarding = true;
            }

            if (empty($user->compensation) || empty($user->portfolio_title) || empty($user->portfolio_description) || empty($user->image)) {
                $port = false;
            } else {
                $port = true;
            }

            $users = new LoginUserResource($user);
            $token = $user->createToken('API Token of ' . $user->first_name);

            return $this->success([
                'user' => $users,
                'work_details' => $onboarding,
                'portofolio' => $port,
                'token' => $token->plainTextToken
            ]);
        } elseif ($businessGuard->attempt($request->only(['email_address', 'password']))) {
            $stud = Business::where('email_address', $request->email_address)->first();

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

            $studs = new LoginUserResource($stud);
            $token = $stud->createToken('API Token of ' . $stud->first_name);

            return $this->success([
                'user' => $studs,
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

        $user = Talent::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'type' => 'talent',
            'otp' => Str::random(60),
            'status' => 'Inactive',
        ]);

        Mail::to($request->email_address)->send(new TalentVerifyEmail($user));

        return $this->success([
            'talent' => $user,
        ]);
    }

    public function verify($token)
    {
        // Find the user with the provided token
        $user = Talent::where('otp', $token)->first();

        // Check if the user with the token exists
        if (!$user) {
            // Token not found or invalid
            return $this->error('', 422, 'Error');
        }

        // Update the status and remove the verification token
        $user->status = 'Active';
        $user->otp = null;
        $user->save();

        // You can redirect the user to a success page or any other desired destination
        return [
            "status" => 'true',
            "message" => 'Verification successful'
        ];
    }

    public function redirectToGoogle()
    {
        // return Socialite::driver('google')->stateless()->redirect();

        $query = http_build_query([
            'client_id' => '762091720399-a52pvivgs08fojnqp08fkh9q8fp28tej.apps.googleusercontent.com',
            'redirect_uri' => 'https://myspurr.azurewebsites.net/api/auth/google/callback',
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/userinfo.email', // Define the scopes you need
        ]);

        return redirect('https://accounts.google.com/o/oauth2/auth?' . $query);
    }

    public function handleGoogleCallback()
    {

        $code = request('code');

        $response = Http::post('https://accounts.google.com/o/oauth2/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => '762091720399-a52pvivgs08fojnqp08fkh9q8fp28tej.apps.googleusercontent.com',
                'client_secret' => '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',
                'redirect_uri' => 'https://myspurr.azurewebsites.net/api/auth/google/callback',
                'code' => $code,
            ],
        ]);

        // Check if the response contains an error
        if ($response->json() && array_key_exists('error', $response->json())) {
            return 'Error: ' . $response->json()['error'];
        }

        // Extract the access token from the response
        $accessToken = $response->json()['access_token'] ?? null;

        if (!$accessToken) {
            return 'Access token not found in the response.';
        }

        try {

            $user = Auth::user();
            $finduser = Talent::where('email_address', $user->email_address)->first();

            if ($finduser) {
                return 'Hii';
            } else {
                $newUser = Talent::create([
                    'first_name' => $user->name,
                    'email_address' => $user->email,

                    'password' => encrypt('123456dummy')
                ]);
                return 'Hiaaai';
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function businessRegister(StoreBusinessRequest $request)
    {

        $request->validated($request->all());

        $user = Business::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'type' => 'business',
            'terms' => $request->terms,
            'otp' => Str::random(60),
            'status' => 'Inactive',
        ]);

        Mail::to($request->email_address)->send(new BusinessVerifyEmail($user));

        return $this->success([
            'talent' => $user,
        ]);
    }

    public function verifys($token)
    {
        // Find the user with the provided token
        $user = Business::where('otp', $token)->first();

        // Check if the user with the token exists
        if (!$user) {
            // Token not found or invalid
            return $this->error('', 'Error', 422);
        }

        // Update the status and remove the verification token
        $user->status = 'Active';
        $user->otp = null;
        $user->save();

        // You can redirect the user to a success page or any other desired destination
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

        return $this->success([
            'message' => 'You have successfully logged out and your token has been deleted'
        ]);
    }
}
