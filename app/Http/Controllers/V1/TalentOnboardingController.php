<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\TalentPortfolioRequest;
use App\Http\Requests\V1\TalentWorkDetailsRequest;
use App\Http\Resources\V1\TalentPortfolioResource;
use App\Http\Resources\V1\TalentWorkDetailsResource;
use App\Models\V1\Talent;
use App\Models\V1\TalentImages;
use App\Models\V1\TopSkill;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class TalentOnboardingController extends Controller
{
    use HttpResponses;

    public function workDetails(TalentWorkDetailsRequest $request)
    {
        $user = Auth::user();

        $talent = Talent::where('email_address', $user->email_address)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        $talent->update([
            'skill_title' => $request->skill_title,
            'highest_education' => $request->highest_education,
            'year_obtained' => $request->year_obtained,
            'work_history' => $request->work_history,
            'certificate_earned' => $request->certificate_earned,
            'availability' => $request->availability
        ]);

        foreach ($request->top_skills as $skills) {
            $skill = new TopSkill($skills);
            $talent->topskills()->save($skill);
        }

        $talents = new TalentWorkDetailsResource($talent);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully',
            "data" => $talents
        ];
    }

    public function portfolio(TalentPortfolioRequest $request)
    {
        $user = Auth::user();

        $talent = Talent::where('email_address', $user->email_address)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }


        $talent->update([
            'compensation' => $request->compensation,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description
        ]);

        foreach ($request->image as $image) {

            if($image){
                $file = $image;
                $folderName = 'https://myspurr.azurewebsites.net/talents';
                $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                $replace = substr($file, 0, strpos($file, ',')+1);
                $sig = str_replace($replace, '', $file);

                $sig = str_replace(' ', '+', $sig);
                $file_name = time().'.'.$extension;
                file_put_contents(public_path().'/talents/'.$file_name, base64_decode($sig));

                $pathss = $folderName.'/'.$file_name;
            }else{
                $pathss = "";
            }

            $img = new TalentImages(['image' => $pathss]);
            $talent->questions()->save($img);
        }

        $talents = new TalentPortfolioResource($talent);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully',
            "data" => $talents
        ];
    }

    public function editProfile(Request $request){

        $user = Auth::user();

        $talent = Talent::where('email_address', $user->email_address)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        if($request->image){
            $file = $request->image;
            $folderName = 'https://myspurr.azurewebsites.net/talents';
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            file_put_contents(public_path().'/talents/'.$file_name, base64_decode($sig));

            $pathss = $folderName.'/'.$file_name;
        }else{
            $pathss = $talent->image;
        }

        $talent->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'skill_title' => $request->skill_title,
            'top_skills' => $request->top_skills,
            'highest_education' => $request->highest_education,
            'year_obtained' => $request->year_obtained,
            'work_history' => $request->work_history,
            'certificate_earned' => $request->certificate_earned,
            'availability' => $request->availability,
            'compensation' => $request->compensation,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'image' => $pathss,
            'social_media_link' => $request->social_media_link,
        ]);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully'
        ];

    }
}
