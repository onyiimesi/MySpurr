<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BusinessDetailsRequest;
use App\Http\Requests\V1\BusinessPortfolioRequest;
use App\Http\Resources\V1\BusinessDetailsResource;
use App\Http\Resources\V1\BusinessPortfolioResource;
use App\Models\V1\Business;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class BusinessOnboardingController extends Controller
{

    use HttpResponses;

    public function businessDetails(BusinessDetailsRequest $request)
    {
        $user = Auth::user();

        $business = Business::where('email', $user->email)->first();

        if(!$business){
            return $this->error('', 401, 'Error');
        }

        $business->update([
            'business_name' => $request->business_name,
            'location' => $request->location,
            'industry' => $request->industry,
            'about_business' => $request->about_business,
            'website' => $request->website,
            'business_service' => $request->business_service,
            'business_email' => $request->business_email
        ]);

        $businesss = new BusinessDetailsResource($business);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully',
            "data" => $businesss
        ];
    }

    public function portfolio(BusinessPortfolioRequest $request)
    {
        $user = Auth::user();

        $talent = Business::where('email', $user->email)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        if($request->company_logo){
            $file = $request->company_logo;
            $folderName = 'https://myspurr.azurewebsites.net/business';
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

        $talent->update([
            'company_logo' => $pathss,
            'company_type' => $request->company_type,
            'social_media' => $request->social_media,
            'social_media_two' => $request->social_media_two
        ]);

        $talents = new BusinessPortfolioResource($talent);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully',
            "data" => $talents
        ];
    }

    public function editProfile(Request $request){

        $user = Auth::user();

        $business = Business::where('email', $user->email)->first();

        if(!$business){
            return $this->error('', 401, 'Error');
        }

        if($request->company_logo){
            $file = $request->company_logo;
            $folderName = 'https://myspurr.azurewebsites.net/business';
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

        return [
            "status" => 'true',
            "message" => 'Updated Successfully'
        ];

    }
}
