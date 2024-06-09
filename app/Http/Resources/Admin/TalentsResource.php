<?php

namespace App\Http\Resources\Admin;

use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TalentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $talent = Talent::where('id', $this->id)->first();
        if ($talent && $talent->skill_title !== null) {
            $query = TalentJob::query();
            $query->where('job_title', 'LIKE', '%' . $talent->skill_title . '%');
            $count = $query->count();
        } else {
            $count = 0;
        }

        return [
            'id' => (int)$this->id,
            'uuid' => (string)$this->uuid,
            'name' => (string)$this->first_name . ' ' . $this->last_name,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'email' => (string)$this->email,
            'category' => (string)$this->skill_title,
            'plan' => "free",
            'balance' => 0,
            'total_earning' => 0,
            'executed_jobs' => 0,
            'active_jobs' => 0,
            'verified' => strtolower($this->status) == "active" ? "yes" : "no",
            'location' => (string)$this->location,
            'phone_number' => (string)$this->phone_number,
            'applied_jobs' => optional($this->jobapply)->count(),
            'matched_jobs' => $count,
            'image' => (string)$this->image,
            'verified_documents' => [],
            'status' => (string)strtolower($this->status),
            'joined' => (string)Carbon::parse($this->created_at)->format('d M Y')
        ];
    }
}
