<?php

namespace App\Services\Admin;

use App\Enum\UserStatus;
use App\Events\v1\TalentWelcomeEvent;
use App\Http\Resources\Admin\TalentsResource;
use App\Models\V1\Talent;
use App\Traits\HttpResponses;

class TalentService
{
    use HttpResponses;

    public function index()
    {
        $perPage = request()->query('per_page', 25);
        $searchFilter = request()->query('searchFilter', []);

        $query = Talent::with(['jobapply']);

        if (is_string($searchFilter)) {
            $searchFilter = json_decode($searchFilter, true);
        }

        if (isset($searchFilter['name'])) {
            $query->where(function ($query) use ($searchFilter) {
                $query->where('first_name', 'like', '%' . $searchFilter['name'] . '%')
                      ->orWhere('last_name', 'like', '%' . $searchFilter['name'] . '%');
            });
        }

        if (isset($searchFilter['email'])) {
            $query->where('email', 'like', '%' . $searchFilter['email'] . '%');
        }

        if(isset($searchFilter['skill_title'])) {
            $query->where('skill_title', 'like', '%' . $searchFilter['skill_title'] . '%');
        }

        $talents = $query->paginate($perPage);

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

        if($request->status === "active"){
            event(new TalentWelcomeEvent($talent));
        }

        $status = $request->status;

        if($request->verified == "yes") {
            $otp = null;
            $otp_expires_at = null;
            $status = UserStatus::ACTIVE;
        } elseif($request->verified == "no") {
            $otp = $talent->otp;
            $otp_expires_at = $talent->otp_expires_at;
            $status = UserStatus::INACTIVE;
        }

        $talent->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location' => $request->location,
            'skill_title' => $request->category,
            'phone_number' => $request->phone_number,
            'otp' => $otp,
            'otp_expires_at' => $otp_expires_at,
            'status' => $status,
        ]);

        return $this->success(null, "Updated successfully");
    }

    public function deleteTalent($id)
    {
        $talent = Talent::withTrashed()->findOrFail($id);
        $talent->forceDelete();

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

