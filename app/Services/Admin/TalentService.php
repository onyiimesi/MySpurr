<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\TalentsResource;
use App\Models\V1\Talent;
use App\Traits\HttpResponses;

class TalentService
{
    use HttpResponses;

    public function index()
    {
        $talents = Talent::with(['jobapply'])->paginate(25);
        $talents = TalentsResource::collection($talents);

        return [
            'status' => true,
            'message' => "All Talents",
            'value' => [
                'result' => $talents,
                'current_page' => $talents->currentPage(),
                'page_count' => $talents->lastPage(),
                'page_size' => $talents->perPage(),
                'total_records' => $talents->total()
            ]
        ];
    }
}

