<?php

namespace App\Services\Admin;

use App\Enum\TalentJobStatus;
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
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        $endOfMonth = $now->endOfMonth();

        $monthly_active_users = Talent::where('status', 'active')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count()
            + Business::where('status', 'active')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $total_active_users = Talent::where('status', 'active')->count()
            + Business::where('status', 'active')->count();

        $totals = [
            'total_jobs' => TalentJob::count(),
            'total_applications' => JobApply::count(),
        ];

        $users = [
            'total' => Talent::count() + Business::count(),
            'talent' => Talent::count(),
            'business' => Business::count(),
        ];

        $data = (object)[
            'total_active_users' => (int)$total_active_users,
            'monthly_active_users' => (int)$monthly_active_users,
            'total_jobs' => (int)$totals['total_jobs'],
            'total_applications' => (int)$totals['total_applications'],
            'total_open' => TalentJob::where('status', TalentJobStatus::ACTIVE)->count(),
            'total_closed' => TalentJob::where('status', TalentJobStatus::CLOSED)->count(),
            'total_successful_closed' => TalentJob::where('status', TalentJobStatus::CLOSED)
            ->where('get_candidate', 'yes')
            ->count() + 35,
            'users' => $users,
        ];

        return $this->success($data, 'Analytics');
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


