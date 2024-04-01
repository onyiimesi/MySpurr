<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\JobApply;
use App\Models\V1\JobView;
use App\Models\V1\TalentJob;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobStatisticsController extends Controller
{
    use HttpResponses;

    public function stats(Request $request)
    {
        $user = Auth::user();

        $filter = $request->query('filter');

        $jobs = TalentJob::where('business_id', $user->id)
        ->where('status', 'active')
        ->get();

        $jobid = $jobs->pluck('id');

        $startDate = Carbon::now();
        $endDate = Carbon::now();

        switch ($filter) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                break;
        }

        $jobViewData = JobView::whereIn('talent_job_id', $jobid)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

        $jobApplyData = JobApply::whereIn('job_id', $jobid)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

        return $this->success([
            [
                'job_views' => $jobViewData,
                'job_applied' => $jobApplyData
            ]
        ]);
    }
}
