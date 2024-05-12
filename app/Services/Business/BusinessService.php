<?php

namespace App\Services\Business;

use App\Models\V1\Business;
use App\Services\CountryState\CountryDetailsService;
use App\Services\CountryState\StateDetailsService;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class BusinessService
{
    use HttpResponses;

    public function businessDetails($request)
    {
        $user = Auth::user();

        $business = Business::where('email', $user->email)->first();

        if(!$business){
            return $this->error('', 401, 'Error');
        }

        if($request->company_logo){
            $file = $request->company_logo;
            $folderName = config('services.company_logo');
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            file_put_contents(public_path().'/business/'.$file_name, base64_decode($sig));

            $pathss = $folderName.'/'.$file_name;
        }else{
            $pathss = "";
        }

        $state = (new StateDetailsService($request->ciso, $request->siso))->run();
        $country = (new CountryDetailsService($request->ciso))->run();

        $business->update([
            'business_name' => $request->business_name,
            'location' => $state->name . ', '. $country->name,
            'ciso' => $request->ciso,
            'siso' => $request->siso,
            'longitude' => $state->longitude,
            'latitude' => $state->latitude,
            'industry' => $request->industry,
            'about_business' => $request->about_business,
            'website' => $request->website,
            'business_service' => $request->business_service,
            'business_email' => $request->business_email,
            'company_logo' => $pathss,
            'company_type' => $request->company_type,
        ]);

        return $this->success(null, "Updated Successfully");
    }

    public function editProfile($request)
    {
        $user = Auth::user();

        $business = Business::where('email', $user->email)->first();

        if(!$business){
            return $this->error('', 401, 'Error');
        }

        if($request->company_logo){
            $file = $request->company_logo;
            $folderName = config('services.company_logo');
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            file_put_contents(public_path().'/business/'.$file_name, base64_decode($sig));

            $pathss = $folderName.'/'.$file_name;
        }else{
            $pathss = $business->company_logo;
        }

        $business->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'business_name' => $request->business_name,
            'country_code' => $request->country_code,
            'phone_number' => $request->phone_number,
            'location' => $request->location,
            'industry' => $request->industry,
            'about_business' => $request->about_business,
            'website' => $request->website,
            'business_service' => $request->business_service,
            'business_email' => $request->business_email,
            'company_logo' => $pathss,
            'company_type' => $request->company_type,
            'social_media' => $request->social_media,
            'social_media_two' => $request->social_media_two
        ]);

        return $this->success(null, "Updated Successfully");
    }
}

