<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\JobResource;
use App\Models\V1\Business;
use App\Models\V1\JobApply;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use App\Traits\HttpResponses;
use Illuminate\Support\Carbon;

class AdminService
{
    use HttpResponses;

    public function overview()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthly_active_users = Talent::where('status', 'active')
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->count() + Business::where('status', 'active')
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->count();

        $total_active_users = Talent::where('status', 'active')->count() + Business::where('status', 'active')->count();
        $total_jobs = TalentJob::where('status', 'active')->count();
        $total_applications = JobApply::count();

        return $this->success([
            'total_active_users' => (int)$total_active_users,
            'monthly_active_users' => (int)$monthly_active_users,
            'total_jobs' => (int)$total_jobs,
            'total_applications' => (int)$total_applications
        ]);
    }

    public function latestJobs()
    {
        $job = TalentJob::where('status', 'active')
        ->orderByDesc('is_highlighted')
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
}


