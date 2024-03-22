<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\JobRequest;
use App\Http\Resources\V1\JobResource;
use App\Models\V1\Business;
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

        $job = TalentJob::where('business_id', $user->id)
        ->where('status', 'active')
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

        if($business->talentjob()->count() >= 1){
            return $this->error('', 400, 'Job posting limit reached. Please make a payment to post more jobs.');
        }

        $job = TalentJob::create([
            'business_id' => $business->id,
            'job_title' => $request->job_title,
            'slug' => Str::slug($request->job_title),
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

        foreach ($request->questions as $questionData) {
            $question = new Question($questionData);
            $job->questions()->save($question);
        }

        return [
            "status" => 'true',
            "message" => 'Job Created Successfully'
        ];

    }

    /**
     * Display the specified resource.
     */
    public function show(TalentJob $job)
    {
        $jobs = new JobResource($job);

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
