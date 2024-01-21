<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Talent;
use App\Models\V1\TalentCertificate;
use App\Models\V1\TopSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;
use App\Repositories\ProfileRepository;
use App\Services\CountryState\StateDetailsService;

class TalentProfileUpdateController extends Controller
{
    use HttpResponses;

    public function __construct(private ProfileRepository $profile)
    {
        $this->profile = $profile;
    }

    public function updatePhoto(Request $request){

        $user = Auth::user();

        if(!$user){
            return $this->error('', 401, 'Unauthorized');
        }

        $talent = Talent::where('email', $user->email)->first();

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
            'image' => $pathss
        ]);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully'
        ];

    }

    public function updateBio(Request $request){

        try {

            $state = (new StateDetailsService($request->ciso, $request->siso))->run();

            $this->profile->updateProfile([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'skill_title' => $request->skill_title,
                'rate' => $request->rate,
                'location' => $request->location,
                'ciso' => $request->ciso,
                'siso' => $request->siso,
                'longitude' => $state->longitude,
                'latitude' => $state->latitude,
                'linkedin' => $request->linkedin,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'behance' => $request->behance,
                'facebook' => $request->facebook
            ]);

            return [
                'status' => 'true',
                'message' => 'Updated successfully'
            ];

        } catch (\Throwable $th) {

            return [
                'status' => 'false',
                'message' => $th->getMessage()
            ];

        }
    }

    public function updateOverview(Request $request)
    {

        $this->profile->updateProfile([
            'overview' => $request->overview
        ]);

        return [
            'status' => 'true',
            'message' => 'Updated successfully'
        ];
    }

    public function updateSkills(Request $request)
    {

        $user = Auth::user();

        if(!$user){
            return $this->error('', 401, 'Unauthorized');
        }

        $talent = Talent::where('email', $user->email)->first();

        $talent->topskills()->delete();
        foreach ($request->top_skills as $skills) {
            $skill = new TopSkill($skills);
            $talent->topskills()->save($skill);
        }

        return [
            'status' => 'true',
            'message' => 'Updated successfully'
        ];
    }

    public function updateEdu(Request $request)
    {

        $user = Auth::user();
        if(!$user){
            return $this->error('', 401, 'Unauthorized');
        }

        $talent = Talent::where('email', $user->email)->first();
        $talent->educations()->create([
            'school_name' => $request->education['school_name'],
            'degree' => $request->education['degree'],
            'start_date' => $request->education['start_date'],
            'end_date' => $request->education['end_date'],
            'description' => $request->education['description'],
            'currently_schooling_here' => $request->education['currently_schooling_here']
        ]);

        return [
            'status' => 'true',
            'message' => 'Updated successfully'
        ];
    }

    public function updateWork(Request $request)
    {

        $user = Auth::user();
        if(!$user){
            return $this->error('', 401, 'Unauthorized');
        }
        $talent = Talent::where('email', $user->email)->first();
        $talent->employments()->create([
            'company_name' => $request->employment_details['company_name'],
            'title' => $request->employment_details['title'],
            'employment_type' => $request->employment_details['employment_type'],
            'start_date' => $request->employment_details['start_date'],
            'end_date' => $request->employment_details['end_date'],
            'description' => $request->employment_details['description'],
            'currently_working_here' => $request->employment_details['currently_working_here']
        ]);

        return [
            'status' => 'true',
            'message' => 'Updated successfully'
        ];
    }

    public function addCert(Request $request)
    {

        $user = Auth::user();
        if(!$user){
            return $this->error('', 401, 'Unauthorized');
        }
        $talent = Talent::where('email', $user->email)->first();

        $talent->certificates()->create([
            'title' => $request->title,
            'institute' => $request->institute,
            'certificate_date' => $request->certificate_date,
            'certificate_year' => $request->certificate_year,
            'certificate_link' => $request->certificate_link,
            'currently_working_here' => $request->currently_working_here
        ]);
        return [
            'status' => 'true',
            'message' => 'Added successfully'
        ];
    }

    public function upload (Request $request)
    {
        $request->validate([
            'country' => ['required'],
            'document_type' => ['required'],
            'front' => ['required'],
            'back' => ['required'],
            'confirm' => ['required']
        ]);

        $user = Auth::user();
        $talent = Talent::where('email', $user->email)->first();

        if($request->front){
            $file = $request->front;
            $folderName = env('BASE_URL_IDENTITY');
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);
            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            $path = public_path().'/documents/'.$file_name;
            $success = file_put_contents($path, base64_decode($sig));
            if ($success === false) {
                throw new \Exception("Failed to write file to disk.");
            }
            $front = $folderName.'/'.$file_name;
        } else {
            $front = "";
        }

        if($request->back){
            $file = $request->back;
            $folderName = env('BASE_URL_IDENTITY');
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);
            $sig = str_replace(' ', '+', $sig);
            $file_name = uniqid().'.'.$extension;
            $path = public_path().'/documents/'.$file_name;
            $success = file_put_contents($path, base64_decode($sig));
            if ($success === false) {
                throw new \Exception("Failed to write file to disk.");
            }
            $back = $folderName.'/'.$file_name;
        } else {
            $back = "";
        }

        $talent->talentidentity()->create([
            'country' => $request->country,
            'document_type' => $request->document_type,
            'front' => $front,
            'back' => $back,
            'confirm' => $request->confirm,
            'status' => 'not-approved'
        ]);

        return $this->success('', "Uploaded successfully", 200);
    }
}
