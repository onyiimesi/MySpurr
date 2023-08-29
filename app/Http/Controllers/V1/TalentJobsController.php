<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TalentJobResource;
use App\Models\V1\Job;
use Illuminate\Http\Request;

class TalentJobsController extends Controller
{
    public function jobs()
    {
        $job = Job::where('status', 'active')->get();

        $jobs = TalentJobResource::collection($job);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $jobs
        ];
    }
}
