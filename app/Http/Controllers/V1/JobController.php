<?php

namespace App\Http\Controllers\V1;

use App\Enum\TalentJobType;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\JobRequest;
use App\Http\Resources\V1\JobResource;
use App\Models\V1\Business;
use App\Models\V1\JobView;
use App\Models\V1\Question;
use App\Models\V1\TalentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;

class JobController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $job = TalentJob::with(['business', 'questions', 'jobapply'])
        ->where('business_id', $user->id)
        ->where('status', 'active')
        ->orderByDesc('is_highlighted')
        ->orderByDesc('created_at')
        ->paginate(25);

        $jobs = JobResource::collection($job);

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        $request->validated($request->all());

        $user = Auth::user();
        $business = Business::where('email', $user->email)->first();
        if(!$business){
            return $this->error('', 401, 'Error');
        }

        // if($business->talentjob()->count() >= 1){
        //     return $this->error('', 400, 'Job posting limit reached. Please make a payment to post more jobs.');
        // }

        $slug = Str::slug($request->job_title);

        if (TalentJob::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }

        $job = TalentJob::create([
            'business_id' => $business->id,
            'job_title' => $request->job_title,
            'slug' => $slug,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'required_skills' => $request->required_skills,
            'benefits' => $request->benefits,
            'salaray_type' => $request->salaray_type,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'currency' => $request->currency,
            'skills' => $request->skills,
            'experience' => $request->experience,
            'qualification' => $request->qualification,
            'status' => 'active',
        ]);

        if (!empty($request->questions)) {
            foreach ($request->questions as $questionData) {
                $question = new Question($questionData);
                $job->questions()->save($question);
            }
        }

        $business->talentjobtypes()->update(['is_active' => 0]);

        if ($request->type === TalentJobType::STANDARD) {
            $talentJobType = $business->talentjobtypes()->where('type', TalentJobType::STANDARD)->first();

            if ($talentJobType) {
                if ($talentJobType->attempt >= 3) {
                    return $this->error(null, 400, "You have exhausted your 3 free attempts. To continue use premium.");
                } else {
                    $talentJobType->increment('attempt');
                    $talentJobType->update(['is_active' => 1]);
                }
            } else {
                $business->talentjobtypes()->create([
                    'type' => $request->type,
                    'attempt' => 1,
                    'is_active' => 1
                ]);
            }
        }

        return $this->success(null, "Job Created Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, TalentJob $job)
    {
        $user = Auth::user();
        $userId = $user->id;

        $jobs = new JobResource($job);

        $sessionId = null;
        if (!$userId) {
            $sessionId = $request->session()->getId();
        }

        if (auth()->check()) {
            $existingView = JobView::where('talent_job_id', $job->id)
            ->where('talent_id', $userId)
            ->exists();
        } else {
            $existingView = JobView::where('talent_job_id', $job->id)
            ->where('session_id', $sessionId)
            ->exists();
        }

        if ($existingView) {
            $data = new JobResource($job);
            return $this->success($data, "Details", 200);
        }

        $job->views()->create([
            'session_id' => $sessionId,
            'talent_id' => $userId
        ]);

        return [
            'status' => 'true',
            'message' => 'Job Details',
            'data' => $jobs
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TalentJob $job)
    {
        $job->update($request->all());

        $job->questions()->delete();
        foreach ($request->questions as $questionData) {
            $question = new Question($questionData);
            $job->questions()->save($question);
        }

        return [
            "status" => 'true',
            "message" => 'Updated Successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
    }
}
