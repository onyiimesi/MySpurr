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

        $talent = Talent::where('email', $user->email)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        $talent->update([
            'skill_title' => $request->skill_title,
            'overview' => $request->overview,
            'location' => $request->location,
            'employment_type' => $request->employment_type,
            'highest_education' => $request->highest_education,
            'rate' => $request->rate,
            'availability' => $request->availability
        ]);

        try {

            $talent->educations()->create([
                'school_name' => $request->education['school_name'],
                'degree' => $request->education['degree'],
                'field_of_study' => $request->education['field_of_study'],
                'start_date' => $request->education['start_date'],
                'end_date' => $request->education['end_date'],
                'description' => $request->education['description']
            ]);

        } catch (\Exception $e) {
            return $e;
        }

        try {

            $talent->employments()->create([
                'company_name' => $request->employment_details['company_name'],
                'title' => $request->employment_details['title'],
                'employment_type' => $request->employment_details['employment_type'],
                'start_date' => $request->employment_details['start_date'],
                'end_date' => $request->employment_details['end_date'],
                'description' => $request->education['description']
            ]);

        } catch (\Exception $e) {
            return $e;
        }

        try {

            $talent->certificates()->create([
                'title' => $request->certificate['title'],
                'institute' => $request->certificate['institute'],
                'certificate_date' => $request->certificate['certificate_date'],
                'certificate_year' => $request->certificate['certificate_year'],
                'certificate_link' => $request->certificate['certificate_link'],
                'currently_working_here' => $request->certificate['currently_working_here']
            ]);

        } catch (\Exception $e) {
            return $e;
        }

        foreach ($request->top_skills as $skills) {
            $skill = new TopSkill($skills);
            $talent->topskills()->save($skill);
        }

        return [
            "status" => 'true',
            "message" => 'Updated Successfully'
        ];
    }

    public function portfolio(Request $request)
    {

        // $request->validated();
        $user = Auth::user();

        $talent = Talent::where('email', $user->email)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        if($request->portfolio['cover_image']){
            $file = $request->portfolio['cover_image'];
            $folderName = 'https://myspurr.azurewebsites.net/portfolio';
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            file_put_contents(public_path().'/portfolio/'.$file_name, base64_decode($sig));

            $pathss = $folderName.'/'.$file_name;
        }else{
            $pathss = "";
        }

        $body = $request->portfolio['body'];

        $talent->portfolios()->create([
            'title' => $request->portfolio['title'],
            'client_name' => $request->portfolio['client_name'],
            'job_type' => $request->portfolio['job_type'],
            'location' => $request->portfolio['location'],
            'rate' => $request->portfolio['rate'],
            'tags' => json_encode($request->portfolio['tags']),
            'cover_image' => $pathss,
            'body' => $body
        ]);

        return [
            "status" => 'true',
            "message" => 'Created Successfully'
        ];
    }

    public function editProfile(Request $request){

        $user = Auth::user();

        $talent = Talent::where('email', $user->email)->first();

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
