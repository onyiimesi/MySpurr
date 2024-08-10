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

        $jobIds = $jobs->pluck('id');

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
                $filter = 'default'; // or handle default case
                break;
        }

        $jobViewData = JobView::whereIn('talent_job_id', $jobIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $jobApplyData = JobApply::whereIn('job_id', $jobIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $jobViewCount = $jobViewData->count();
        $jobApplyCount = $jobApplyData->count();

        $result = [];

        if ($filter === 'week') {
            $jobAppliesByWeek = array_fill(0, 7, 0);
            $jobViewsByDayOrMonth = array_fill(0, 7, 0);

            foreach ($jobViewData as $view) {
                $dayOfWeek = Carbon::parse($view->created_at)->dayOfWeek;
                $jobViewsByDayOrMonth[$dayOfWeek]++;
            }

            foreach ($jobApplyData as $apply) {
                $dayOfWeek = Carbon::parse($apply->created_at)->dayOfWeek;
                $jobAppliesByWeek[$dayOfWeek]++;
            }

            $firstDayOfWeek = Carbon::now()->startOfWeek()->dayOfWeek;
            for ($i = 0; $i < 7; $i++) {
                $dayIndex = ($firstDayOfWeek + $i) % 7;
                $result[] = [
                    'day' => Carbon::now()->startOfWeek()->addDays($i)->format('D'),
                    'job_views' => $jobViewsByDayOrMonth[$dayIndex],
                    'job_applied' => $jobAppliesByWeek[$i],
                ];
            }
        } elseif ($filter === 'month') {
            $jobViewsByMonth = array_fill(1, 12, 0);
            $jobAppliesByMonth = array_fill(1, 12, 0);

            foreach ($jobViewData as $view) {
                $monthOfYear = Carbon::parse($view->created_at)->month;
                $jobViewsByMonth[$monthOfYear]++;
            }

            foreach ($jobApplyData as $apply) {
                $monthOfYear = Carbon::parse($apply->created_at)->month;
                $jobAppliesByMonth[$monthOfYear]++;
            }

            for ($i = 1; $i <= 12; $i++) {
                $result[] = [
                    'month' => Carbon::createFromDate(null, $i, null)->format('M'),
                    'job_views' => $jobViewsByMonth[$i],
                    'job_applied' => $jobAppliesByMonth[$i],
                ];
            }
        }

        $result[] = [
            'total_job_views' => $jobViewCount,
            'total_job_applied' => $jobApplyCount,
        ];

        return $this->success($result);
    }

}
