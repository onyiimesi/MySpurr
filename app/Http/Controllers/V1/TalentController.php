<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JobTitleResource;
use App\Http\Resources\V1\TalentListResource;
use App\Http\Resources\V1\TalentResource;
use App\Models\V1\JobTitle;
use App\Models\V1\Talent;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    public function listtalents()
    {
        $talents = Talent::where('status', 'Active')->paginate(25);

        $talent = TalentListResource::collection($talents);

        return [
            'status' => 'true',
            'message' => 'Talent List',
            'data' => $talent,
            'pagination' => [
                'current_page' => $talents->currentPage(),
                'last_page' => $talents->lastPage(),
                'per_page' => $talents->perPage(),
                'prev_page_url' => $talents->previousPageUrl(),
                'next_page_url' => $talents->nextPageUrl(),
            ],
        ];
    }

    public function talentbyid(Request $request)
    {
        $talents = Talent::where('status', 'Active')
        ->where('uuid', $request->uuid)
        ->firstOrFail();

        $talent = new TalentResource($talents);

        return [
            'status' => 'true',
            'message' => 'Talent Details',
            'data' => $talent
        ];
    }

    public function jobtitle()
    {
        $title = JobTitle::get();
        $titles = JobTitleResource::collection($title);

        return [
            "status" => 'true',
            "message" => 'Job Title List',
            "data" => $titles
        ];
    }
}
