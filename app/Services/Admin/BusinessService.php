<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\BusinessResource;
use App\Models\V1\Business;
use App\Traits\HttpResponses;

class BusinessService
{
    use HttpResponses;

    public function index()
    {
        $perPage = request()->query('per_page', 25);
        $business = Business::with(['talentjob'])->paginate($perPage);
        $business = BusinessResource::collection($business);

        return [
            'status' => true,
            'message' => "All Business",
            'value' => [
                'result' => $business,
                'current_page' => $business->currentPage(),
                'page_count' => $business->lastPage(),
                'page_size' => $business->perPage(),
                'total_records' => $business->total()
            ]
        ];
    }
}





