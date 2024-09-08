<?php

namespace App\Services\Admin\Jobs;

use App\Http\Resources\Admin\AdminJobResource;
use App\Models\V1\TalentJob;
use App\Traits\HttpResponses;

class JobService
{
    use HttpResponses;

    public function index()
    {
        $perPage = request()->query('per_page', 25);
        $jobs = TalentJob::with(['jobapply'])->paginate($perPage);
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
}



