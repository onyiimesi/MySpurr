<?php

namespace App\Services\Admin\Jobs;

use App\Http\Resources\Admin\AdminExternalJobResource;
use App\Models\Admin\ExternalJob;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;

class ExternalJobService
{
    use HttpResponses;

    public function jobCreate($request)
    {
        try {

            $slug = Str::slug($request->title);

            if (ExternalJob::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . uniqid();
            }

            ExternalJob::create([
                'title' => $request->title,
                'slug' => $slug,
                'company_name' => $request->company_name,
                'location' => $request->location,
                'job_type' => $request->job_type,
                'description' => $request->description,
                'responsibilities' => $request->responsibilities,
                'required_skills' => $request->required_skills,
                'salary_min' => $request->salary_min,
                'salary_max' => $request->salary_max,
                'link' => $request->link,
                'status' => $request->status,
            ]);

            return $this->success(null, 'Created successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index()
    {
        $perPage = request()->query('per_page', 25);

        $jobs = ExternalJob::orderBy('created_at', 'desc')
        ->paginate($perPage);
        $alljobs = AdminExternalJobResource::collection($jobs);

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
        $job = ExternalJob::where('slug', $slug)->firstOrFail();
        $data = new AdminExternalJobResource($job);

        return [
            'status' => true,
            'message' => "Job Details",
            'value' => $data
        ];
    }

    public function editJob($request, $slug)
    {
        $job = ExternalJob::where('slug', $slug)
            ->firstOrFail();

        $slug = $job->title === $request->title
            ? $job->slug
            : Str::slug($request->title);

        if ($slug !== $job->slug && ExternalJob::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }

        $job->update([
            'title' => $request->title,
            'slug' => $slug,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'required_skills' => $request->required_skills,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'link' => $request->link,
            'status' => $request->status,
        ]);

        return $this->success(null, 'Updated successfully');
    }

    public function closeJob($slug)
    {
        $job = ExternalJob::where('slug', $slug)
            ->firstOrFail();

        $job->update([
            'status' => TalentJobStatus::CLOSED,
        ]);

        return $this->success(null, 'Closed successfully');
    }
}
