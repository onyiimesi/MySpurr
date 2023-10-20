<?php

namespace App\Http\Controllers\V1;

use App\Events\v1\TalentWelcomeEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LoginUserResource;
use App\Models\V1\Business;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Traits\HttpResponses;

class GoogleAuthController extends Controller
{

    use HttpResponses;

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {

        $googleUser = Socialite::driver('google')->stateless()->user();

        try {

            $user = Talent::where('email', $googleUser->email)->first();

            if (empty($user->skill_title) || empty($user->topskills) || empty($user->educations) || empty($user->employments) || empty($user->certificates) || empty($user->availability)) {
                $onboarding = false;
            } else {
                $onboarding = true;
            }

            if (empty($user->compensation) || empty($user->portfolio_title) || empty($user->portfolio_description) || empty($user->image)) {
                $port = false;
            } else {
                $port = true;
            }

            if (!$user) {

                $fullName = $googleUser->name;
                list($firstName, $lastName) = explode(' ', $fullName, 2);

                $user = Talent::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $googleUser->email,
                    'password' => Hash::make('12345678'),
                    'type' => 'talent',
                    'status' => 'Active'
                ]);

                try {

                    event(new TalentWelcomeEvent($user));

                } catch (\Exception $e){
                    return $this->error('error', 400, 'Email sending failed!. Try again');
                }

            }

            $users = new LoginUserResource($user);

            $token = $user->createToken('token-name')->plainTextToken;

            $responseData = [
                'user' => [
                    'uuid' => $user->uuid,
                    'first_name' => $user->first_name,
                    'last_name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'type' => 'talent',
                    'status' => 'Active'
                ],
                'work_details' => $onboarding,
                'portfolio' => $port,
                'token' => $token,
            ];

            return redirect()->to('https://mango-glacier-097715310.3.azurestaticapps.net/login?' . http_build_query($responseData));


        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    // public function redirectToGoogleBusiness()
    // {
    //     return Socialite::driver('google')->stateless()
    //         ->redirectUrl(config('services.google.business.redirect'))
    //         ->redirect();
    // }

    // public function handleGoogleCallbackBusiness()
    // {

    //     $googleUser = Socialite::driver('google')->stateless()
    //     ->redirectUrl(config('services.google.business.redirect'))
    //     ->user();

    //     try {

    //         $user = Business::where('email', $googleUser->email)->first();

    //         if (empty($user->business_name) || empty($user->location) || empty($user->industry) || empty($user->about_business) || empty($user->website) || empty($user->business_service) || empty($user->business_email)) {
    //             $onboarding = false;
    //         } else {
    //             $onboarding = true;
    //         }

    //         if (empty($user->company_logo) || empty($user->company_type) || empty($user->social_media)) {
    //             $port = false;
    //         } else {
    //             $port = true;
    //         }

    //         if (!$user) {

    //             $user = Business::create([
    //                 'first_name' => $googleUser->name,
    //                 'last_name' => $googleUser->name,
    //                 'email' => $googleUser->email,
    //                 'password' => Hash::make('12345678'),
    //                 'type' => 'business',
    //                 'status' => 'Active'
    //             ]);

    //         }

    //         $users = new LoginUserResource($user);

    //         $token = $user->createToken('API Token')->plainTextToken;

    //         return $this->success([
    //             'user' => $users,
    //             'business_details' => $onboarding,
    //             'portofolio' => $port,
    //             'token' => $token
    //         ]);


    //     } catch (\Exception $e) {
    //         dd($e->getMessage());
    //     }
    // }
}
