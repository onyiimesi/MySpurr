<?php

namespace App\Http\Resources\V1;

use App\Models\V1\TalentJob;
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
                'job_title' => (string)$job->job_title,
                'location' => (string)$job->location,
                'skills' => (array)$job->skills,
                'rate' => (string)$job->rate,
                'commitment' => (string)$job->commitment,
                'job_type' => (string)$job->job_type,
                'capacity' => (string)$job->capacity,
                'experience' => (string)$job->experience,
                'description' => (string)$job->description,
            ],
            'company' => (object) [
                'business_name' => (string)$job->business?->business_name,
                'about_company' => (string)$job->business?->about_business,
                'industry' => (string)$job->business?->industry,
                'logo' => (string)$job->business?->company_logo,
            ],
        ];
    }
}
