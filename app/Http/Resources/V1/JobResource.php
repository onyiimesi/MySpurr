<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'job_title' => (string)$this->job_title,
            'location' => (string)$this->location,
            'skills' => (string)$this->skills,
            'rate' => (string)$this->rate,
            'commitment' => (string)$this->commitment,
            'job_type' => (string)$this->job_type,
            'capacity' => (string)$this->capacity,
            'status' => (string)$this->status,
            'questions' => $this->questions
        ];
    }
}
