<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\JobApplyRequest;
use App\Http\Resources\V1\BookMarkJobResource;
use App\Http\Resources\V1\JobResource;
use App\Http\Resources\V1\TalentApplicationResource;
use App\Http\Resources\V1\TalentJobResource;
use App\Http\Resources\V1\TalentJobResourceNoAuth;
use App\Mail\v1\BusinessApplicationMail;
use App\Mail\v1\TalentApplyMail;
use App\Models\V1\BookmarkJob;
use App\Models\V1\Job;
use App\Models\V1\JobApply;
use App\Models\V1\Question;
use App\Models\V1\QuestionAnswer;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TalentJobsController extends Controller
{
    use HttpResponses;

    public function jobs()
    {
        $job = TalentJob::with(['jobapply', 'business', 'questions'])
        ->where('status', 'active')
        ->orderByDesc('is_highlighted')
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        $jobs = TalentJobResource::collection($job);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $jobs,
            'pagination' => [
                'current_page' => $job->currentPage(),
                'last_page' => $job->lastPage(),
                'per_page' => $job->perPage(),
                'prev_page_url' => $job->previousPageUrl(),
                'next_page_url' => $job->nextPageUrl()
            ],
        ];
    }

    public function listjobs()
    {
        $job = TalentJob::with(['jobapply', 'business', 'questions'])->where('status', 'active')
        ->orderBy('is_highlighted', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        $jobs = TalentJobResourceNoAuth::collection($job);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $jobs,
            'pagination' => [
                'current_page' => $job->currentPage(),
                'last_page' => $job->lastPage(),
                'per_page' => $job->perPage(),
                'prev_page_url' => $job->previousPageUrl(),
                'next_page_url' => $job->nextPageUrl()
            ],
        ];
    }

    public function apply(JobApplyRequest $request)
    {
        $request->validated($request->all());

        $user = Auth::user();

        $talent = Talent::with('certificates')->where('email', $user->email)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        $job = TalentJob::with('business')->findOrFail($request->job_id);
        $question = Question::where('talent_job_id', $request->job_id)->first();

        $jobApplied = JobApply::where('talent_id', $talent->id)
        ->where('job_id', $request->job_id)
        ->exists();

        if($jobApplied){
            return $this->error(null, 403, 'You have applied for this job.');
        }

        if(! $question){
            return response()->json(['message' => 'Job not found!'], 404);
        }

        if(! empty($request->other_file)){
            $file = $request->other_file;
            $folderName = config('services.file');
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            if($extension == "vnd.openxmlformats-officedocument.wordprocessingml.document"){
                $extension = "docx";
            }elseif($extension == "vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
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

        $jobappy = JobApply::create([
            'talent_id' => $talent->id,
            'job_id' => $request->job_id,
            'slug' => $job->slug,
            'rate' => $request->rate,
            'available_start' => $request->available_start,
            'resume' => $request->resume,
            'other_file' => $files,
            'type' => 'open',
            'status' => 'pending'
        ]);

        if(! empty($request->question_answers)) {
            foreach ($request->question_answers as $answerData) {
                $answer = new QuestionAnswer($answerData);
                $question->answers()->save($answer);
            }
        }

        $this->sendMails($jobappy, $talent, $job);

        return $this->success(null, "Job applied successfully");
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

    public function listjobdetail($slug)
    {
        $job = TalentJob::where('slug', $slug)
        ->where('status', 'active')
        ->first();

        if(!$job){
            return $this->error(null, 400, "Error slug required");
        }

        $data = new JobResource($job);

        return $this->success($data, "Details", 200);
    }

    public function bookmark($id)
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)->first();

        $job = TalentJob::find($id);
        if(!$job){
            return $this->error(null, 404, "Job not found!");
        }

        $checkBook = BookmarkJob::where('job_id', $id)->exists();
        if($checkBook){
            return $this->error(null, 404, "Oops this job has been bookmarked!");
        }

        try {
            DB::transaction(function () use($talent, $job) {

                $book = BookmarkJob::create([
                    'talent_id' => $talent->id,
                    'job_id' => $job->id
                ]);

                if($book){
                    $job->update([
                        'is_bookmark' => 1,
                    ]);
                }
            });

            $message = $this->success(null, "Job bookmarked successfully.", 200);
        } catch (\Throwable $th) {
            $message = $this->error(null, 400, $th->getMessage());
        }

        return $message;
    }

    public function getBookmark()
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)->first();

        $book = BookmarkJob::where('talent_id', $talent->id)->get();
        $book = BookMarkJobResource::collection($book);

        return $this->success($book, "Bookmark List", 200);
    }

    public function deleteBookmark($id)
    {
        $book = BookmarkJob::find($id);
        $book->delete();

        return $this->success(null, "Deleted successfully", 200);
    }

    private function sendMails($jobappy, $talent, $job)
    {
        // Business
        Mail::to(optional($job->business)->email)
        ->send(new BusinessApplicationMail($jobappy, $talent, $job->business, $job));

        $jobs = TalentJob::with(['jobapply', 'business', 'questions'])
        ->where('status', 'active')
        ->orderBy('is_highlighted', 'desc')
        ->orderBy('created_at', 'desc')
        ->take(2)
        ->get();

        // Talent
        Mail::to($talent->email)
        ->send(new TalentApplyMail($jobappy, $talent, $job->business, $job, $jobs));
    }
}


