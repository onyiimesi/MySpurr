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

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        $job = TalentJob::where('business_id', $user->id)
        ->where('status', 'active')
        ->get();

        $jobs = JobResource::collection($job);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $jobs
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {

        $request->validated($request->all());

        $user = Auth::user();

        $business = Business::where('email_address', $user->email_address)->first();

        if(!$business){
            return $this->error('', 401, 'Error');
        }

        $job = TalentJob::create([
            'business_id' => $business->id,
            'job_title' => $request->job_title,
            'location' => $request->location,
            'skills' => $request->skills,
            'rate' => $request->rate,
            'commitment' => $request->commitment,
            'job_type' => $request->job_type,
            'capacity' => $request->capacity,
            'status' => 'active',
        ]);

        foreach ($request->questions as $questionData) {
            $question = new Question($questionData);
            $job->questions()->save($question);
        }

        return [
            "status" => 'true',
            "message" => 'Job Created Successfully',
            "data" => $job
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

        $jobs = new JobResource($job);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully',
            "data" => $jobs
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TalentJob $jobs)
    {
        $jobs->delete();

        return response(null, 204);
    }
}
