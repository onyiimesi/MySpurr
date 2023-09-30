<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'business_name' => (string)$this->business?->business_name
            ],
            'job_title' => (string)$this->job_title,
            'location' => (string)$this->location,
            'skills' => (string)$this->skills,
            'rate' => (string)$this->rate,
            'commitment' => (string)$this->commitment,
            'job_type' => (string)$this->job_type,
            'capacity' => (string)$this->capacity,
            'status' => (string)$this->status
        ];
    }
}
