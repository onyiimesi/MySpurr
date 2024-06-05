<?php

namespace App\Http\Resources\Admin;

use App\Models\V1\JobApply;
use App\Models\V1\JobView;
use App\Models\V1\TalentJob;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $jobs = TalentJob::where('business_id', $this->id)
        ->where('status', 'active')
        ->get();
        $total_open = $jobs->count();

        $total_complete = TalentJob::where('business_id', $this->id)
        ->where('status', 'completed')
        ->count();

        return [
            'id' => (string)$this->id,
            'business_name' => (string)$this->business_name,
            'email' => (string)$this->email,
            'category' => (string)$this->company_type,
            'plan' => "Free",
            'balance' => 0,
            'total_earning' => 0,
            'executed_jobs' => $total_complete,
            'active_jobs' => $total_open,
            'verified' => $this->status == "active" ? "Yes" : "No",
            'phone_number' => (string)$this->phone_number,
            'business_email' => (string)$this->business_email,
            'company_logo' => (string)$this->company_logo,
            'company_type' => (string)$this->company_type,
            'posted_jobs' => optional($this->talentjob)->count(),
            'status' => (string)$this->status
        ];
    }
}
