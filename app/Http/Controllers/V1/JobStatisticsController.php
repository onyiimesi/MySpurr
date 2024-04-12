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
                $startDate = Carbon::now()->startOfYear()->month(1);
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
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

        $jobViewsByDayOrMonth = [];

        if ($filter === 'week') {
            $jobViewsByDayOrMonth = array_fill(0, 7, 0); // 0-indexed, 0 = Sunday, 6 = Saturday

            foreach ($jobViewData as $view) {
                $dayOfWeek = Carbon::parse($view->created_at)->dayOfWeek;
                $jobViewsByDayOrMonth[$dayOfWeek]++;
            }

            $result = [];
            $firstDayOfWeek = Carbon::now()->startOfWeek()->dayOfWeek;
            for ($i = 0; $i < 7; $i++) {
                $dayIndex = ($firstDayOfWeek + $i) % 7; // Calculate the correct index for the day of the week
                $result[] = [
                    'day' => Carbon::now()->startOfWeek()->addDays($i)->format('D'),
                    'job_views' => $jobViewsByDayOrMonth[$dayIndex],
                    'job_applied' => 0, // Placeholder for job applies
                ];
            }
        } elseif ($filter === 'month') {
            $jobViewsByMonth = array_fill(1, 12, 0); // 1-indexed, represents months of the year
            $jobAppliesByMonth = array_fill(1, 12, 0);

            foreach ($jobViewData as $view) {
                $monthOfYear = Carbon::parse($view->created_at)->month;
                $jobViewsByMonth[$monthOfYear]++;
            }

            foreach ($jobApplyData as $apply) {
                $monthOfYear = Carbon::parse($apply->created_at)->month;
                $jobAppliesByMonth[$monthOfYear]++;
            }

            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[] = [
                    'month' => Carbon::createFromDate(null, $i, null)->format('M'), // Format month as month name
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
