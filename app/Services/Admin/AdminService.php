<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\JobResource;
use App\Models\V1\Business;
use App\Models\V1\JobApply;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use App\Models\V1\Visitor;
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
            'value' => [
                'result' => $jobs,
                'current_page' => $job->currentPage(),
                'page_count' => $job->lastPage(),
                'page_size' => $job->perPage(),
                'total_records' => $job->total()
            ]
        ];
    }

    public function visitors()
    {
        $monthlyVisits = Visitor::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($visit) {
                return [
                    'year' => $visit->year,
                    'month' => Carbon::create()->month($visit->month)->format('F'),
                    'count' => $visit->count,
                ];
            });

        return $this->success($monthlyVisits, "Visitors by month");
    }
}


