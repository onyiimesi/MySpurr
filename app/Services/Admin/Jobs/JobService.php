<?php

namespace App\Services\Admin\Jobs;

use Illuminate\Support\Str;
use App\Models\V1\TalentJob;
use App\Traits\HttpResponses;
use App\Http\Resources\Admin\AdminJobResource;
use App\Models\V1\Question;

class JobService
{
    use HttpResponses;

    public function jobCreate($request)
    {
        try {

            $slug = Str::slug($request->job_title);

            if (TalentJob::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . uniqid();
            }

            $job = TalentJob::create([
                'business_id' => $request->business_id,
                'job_title' => $request->job_title,
                'slug' => $slug,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'job_type' => $request->job_type,
                'responsibilities' => $request->responsibilities,
                'required_skills' => $request->required_skills,
                'benefits' => $request->benefits,
                'salaray_type' => $request->salaray_type,
                'salary_min' => $request->salary_min,
                'salary_max' => $request->salary_max,
                'currency' => $request->currency,
                'skills' => $request->skills,
                'description' => $request->description,
                'experience' => $request->experience,
                'qualification' => $request->qualification,
                'is_highlighted' => 1,
                'status' => $request->status,
            ]);

            if (! empty($request->questions)) {
                foreach ($request->questions as $questionData) {
                    $question = new Question($questionData);
                    $job->questions()->save($question);
                }
            }

            return $this->success(null, 'Created successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index()
    {
        $perPage = request()->query('per_page', 25);

        $jobs = TalentJob::with(['jobapply', 'business', 'questions'])->paginate($perPage);
        $alljobs = AdminJobResource::collection($jobs);

        return [
            'status' => true,
            'message' => "All Jobs",
            'value' => [
                'result' => $alljobs,
                'current_page' => $jobs->currentPage(),
                'page_count' => $jobs->lastPage(),
                'page_size' => $jobs->perPage(),
                'total_records' => $jobs->total()
            ]
        ];
    }

    public function getOne($slug)
    {
        $job = TalentJob::where('slug', $slug)->firstOrFail();
        $data = new AdminJobResource($job);

        return [
            'status' => true,
            'message' => "Job Details",
            'value' => $data
        ];
    }

    public function count()
    {
        $data = TalentJob::count();

        return [
            'status' => true,
            'message' => "All Jobs count",
            'value' => $data
        ];
    }
}



