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
        $perPage = request()->query('per_page', 25);
        $talents = Talent::with(['jobapply'])->paginate($perPage);
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

    public function singleTalent($id)
    {
        $talent = Talent::findOrFail($id);
        $data = new TalentsResource($talent);

        return [
            'status' => true,
            'message' => "Talent Details",
            'value' => $data
        ];
    }

    public function editTalent($request, $id)
    {
        $talent = Talent::findOrFail($id);

        $talent->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location' => $request->location,
            'skill_title' => $request->category,
            'phone_number' => $request->phone_number,
            'status' => $request->status
        ]);

        return $this->success(null, "Updated successfully");
    }

    public function deleteTalent($id)
    {
        $talent = Talent::findOrFail($id);
        $talent->delete();

        return $this->success(null, "Deleted successfully");
    }

    public function count()
    {
        $data = Talent::count();

        return [
            'status' => true,
            'message' => "All Talents",
            'value' => $data
        ];
    }
}

