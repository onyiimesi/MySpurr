<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentWorkDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'skill_title' => (string)$this->skill_title,
            'top_skills' => $this->topskills,
            'highest_education' => (string)$this->highest_education,
            'year_obtained' => (string)$this->year_obtained,
            'work_history' => (string)$this->work_history,
            'certificate_earned' => (string)$this->certificate_earned,
            'availability' => (string)$this->availability,
        ];
    }
}
