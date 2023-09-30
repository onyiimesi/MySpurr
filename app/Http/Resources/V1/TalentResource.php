<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'uniqueId' => (string)$this->uuid,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'email' => (string)$this->email,
            'skill_title' => (string)$this->skill_title,
            'top_skills' => $this->topskills->map(function($skill) {
                return [
                    'name' => $skill->name
                ];
            })->toArray(),
            'highest_education' => (string)$this->highest_education,
            'year_obtained' => (string)$this->year_obtained,
            'work_history' => (string)$this->work_history,
            'certificate_earned' => (string)$this->certificate_earned,
            'compensation' => (string)$this->compensation,
            'portfolio_title' => (string)$this->portfolio_title,
            'portfolio_description' => (string)$this->portfolio_description,
            'image' => (string)$this->image,
            'social_media_link' => (string)$this->social_media_link,
            'availability' => (string)$this->availability,
            'type' => (string)$this->type,
            'status' => (string)$this->status
        ];
    }
}
