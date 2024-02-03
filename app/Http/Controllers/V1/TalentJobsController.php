<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\JobApplyRequest;
use App\Http\Resources\V1\TalentApplicationResource;
use App\Http\Resources\V1\TalentJobResource;
use App\Models\V1\Job;
use App\Models\V1\JobApply;
use App\Models\V1\Question;
use App\Models\V1\QuestionAnswer;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TalentJobsController extends Controller
{
    use HttpResponses;

    public function jobs()
    {
        $job = TalentJob::where('status', 'active')->get();
        $jobs = TalentJobResource::collection($job);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $jobs
        ];
    }

    public function listjobs()
    {
        $job = TalentJob::where('status', 'active')->get();
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

        $talent = Talent::where('email', $user->email)->first();

        $question = Question::where('talent_job_id', $id)->first();

        if(!$question){
            return $this->error('', 404, 'Job not found!');
        }

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        if($request->resume){
            $file = $request->resume;
            $folderName = 'https://myspurr.azurewebsites.net/files';
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            if($extension == "vnd.openxmlformats-officedocument.wordprocessingml.document"){
                $extension = "docx";
            }else if($extension == "vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
                $extension = "xlsx";
            }
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
            if($extension == "vnd.openxmlformats-officedocument.wordprocessingml.document"){
                $extension = "docx";
            }else if($extension == "vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
                $extension = "xlsx";
            }
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = uniqid().'.'.$extension;
            file_put_contents(public_path().'/files/'.$file_name, base64_decode($sig));

            $files = $folderName.'/'.$file_name;
        }else{
            $files = "";
        }

        JobApply::create([
            'talent_id' => $talent->id,
            'job_id' => $id,
            'rate' => $request->rate,
            'available_start' => $request->available_start,
            'resume' => $pathss,
            'other_file' => $files,
            'type' => 'open',
            'status' => 'pending'
        ]);

        foreach ($request->question_answers as $answerData) {
            $answer = new QuestionAnswer($answerData);
            $question->answers()->save($answer);
        }

        return [
            "status" => 'true',
            "message" => 'Job applied successfully'
        ];
    }

    public function application()
    {
        $user = Auth::user();
        $talent = Talent::where('uuid', $user->uuid)->first();
        if(!$talent){
            return $this->error('', 401, 'Error');
        }
        $jobappy = JobApply::where('talent_id', $talent->id)->get();
        $applications = TalentApplicationResource::collection($jobappy);

        return $this->success($applications, "All applications", 200);
    }

    public function applicationid($id)
    {
        $user = Auth::user();
        $talent = Talent::where('uuid', $user->uuid)->first();
        if(!$talent){
            return $this->error('', 401, 'Error');
        }
        $jobappy = JobApply::where('id', $id)->first();
        if(!$jobappy){
            return $this->error('', 404, 'Application not found!');
        }
        $applications = new TalentApplicationResource($jobappy);

        return $this->success($applications, "", 200);
    }
}
