<?php

namespace App\Http\Resources\V1;

use App\Models\V1\TalentJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $job = TalentJob::where('id', $this->job_id)->first();
        return [
            'id' => (string)$this->id,
            'type' => (string)$this->type,
            'status' => (string)$this->status,
            'job_info' => (object) [
                'job_title' => (string)$job?->job_title,
                'location' => (string)$job?->location,
                'skills' => (array)$job?->skills,
                'rate' => (string)$job?->rate,
                'commitment' => (string)$job?->commitment,
                'job_type' => (string)$job?->job_type,
                'capacity' => (string)$job?->capacity,
                'experience' => (string)$job?->experience,
                'description' => (string)$job?->description,
                'salary_min' => (string)$job?->salary_min,
                'salary_max' => (string)$job?->salary_max,
                'salaray_type' => (string)$job?->salaray_type,
                'currency' => (string)$job?->currency,
                'country_id' => (string)$job?->country_id,
                'state_id' => (string)$job?->state_id,
                'created_at' => Carbon::parse($job?->created_at)->format('d M Y'),
            ],
            'company' => (object) [
                'business_name' => (string)$job?->business?->business_name,
                'about_company' => (string)$job?->business?->about_business,
                'industry' => (array)$job?->business?->industry,
                'logo' => (string)$job?->business?->company_logo,
            ],
        ];
    }
}
