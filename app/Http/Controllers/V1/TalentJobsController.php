<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\JobApplyRequest;
use App\Http\Resources\V1\TalentJobResource;
use App\Models\V1\Job;
use App\Models\V1\JobApply;
use App\Models\V1\Question;
use App\Models\V1\QuestionAnswer;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TalentJobsController extends Controller
{
    public function jobs()
    {
        $job = Job::where('status', 'active')->get();

        $jobs = TalentJobResource::collection($job);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $jobs
        ];
    }

    public function apply(JobApplyRequest $request, $id)
    {
        $request->validated($request->all());

        $user = Auth::user();

        $talent = Talent::where('email_address', $user->email_address)->first();

        $question = Question::where('job_id', $id)->first();

        if(!$talent){
            return $this->error('', 'Error', 401);
        }

        if($request->resume){
            $file = $request->resume;
            $folderName = 'https://myspurr.azurewebsites.net/files';
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            file_put_contents(public_path().'/files/'.$file_name, base64_decode($sig));

            $pathss = $folderName.'/'.$file_name;
        }else{
            $pathss = "";
        }

        if(!empty($request->other_file)){
            $file = $request->other_file;
            $folderName = 'https://myspurr.azurewebsites.net/files';
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            file_put_contents(public_path().'/files/'.$file_name, base64_decode($sig));

            $files = $folderName.'/'.$file_name;
        }else{
            $files = "";
        }

        $apply = JobApply::create([
            'talent_id' => $talent->id,
            'job_id' => $id,
            'rate' => $request->rate,
            'available_start' => $request->available_start,
            'resume' => $pathss,
            'other_file' => $files,
        ]);

        foreach ($request->question_answers as $answerData) {
            $answer = new QuestionAnswer($answerData);
            $question->answers()->save($answer);
        }

        return [
            "status" => 'true',
            "message" => 'Applied Successfully',
            "data" => $apply
        ];
    }
}
