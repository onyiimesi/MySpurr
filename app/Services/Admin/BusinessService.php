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
        $business = Business::with(['talentjob'])->paginate(25);
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





