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

        // Initialize an array to hold counts for each day of the week
        $jobViewsByDay = array_fill(0, 7, 0); // 0-indexed, 0 = Sunday, 6 = Saturday
        $jobAppliesByDay = array_fill(0, 7, 0);

        foreach ($jobViewData as $view) {
            $dayOfWeek = Carbon::parse($view->created_at)->dayOfWeek;
            $jobViewsByDay[$dayOfWeek]++;
        }

        foreach ($jobApplyData as $apply) {
            $dayOfWeek = Carbon::parse($apply->created_at)->dayOfWeek;
            $jobAppliesByDay[$dayOfWeek]++;
        }

        $result = [];
        $firstDayOfWeek = Carbon::now()->startOfWeek()->dayOfWeek;
        for ($i = 0; $i < 7; $i++) {
            $dayIndex = ($firstDayOfWeek + $i) % 7; // Calculate the correct index for the day of the week
            $result[] = [
                'day' => Carbon::now()->startOfWeek()->addDays($i)->format('D'),
                'job_views' => $jobViewsByDay[$dayIndex],
                'job_applied' => $jobAppliesByDay[$dayIndex],
            ];
        }

        $result[] = [
            'total_job_views' => $jobViewCount,
            'total_job_applied' => $jobApplyCount,
        ];

        return $this->success($result);
    }
}
