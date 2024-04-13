<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uniqueId' => (string)$this->uuid,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'email' => (string)$this->email,
            'skill_title' => (string)$this->skill_title,
            'compensation' => (string)$this->compensation,
            'rate' => (string)$this->rate,
            'location' => (string)$this->location,
            'image' => (string)$this->image,
            'highest_education' => (string)$this->highest_education,
            'employment_type' => (string)$this->employment_type,
            'experience_level' => (string)$this->experience_level,
            'portfolio' => $this->portfolios->map(function($port) {
                return [
                    'id' => $port->id,
                    'title' => $port->title,
                    'category_id' => $port->category_id,
                    'description' => $port->description,
                    'project_image' => $port->portfolioprojectimage->map(function ($data) {
                        return [
                            'id' => $data->id,
                            'image' => $data->image
                        ];
                    })->toArray(),
                    'tags' => json_decode($port->tags),
                    'link' => $port->link,
                    'featured_image' =>  $port->featured_image,
                    'is_draft' =>  $port->is_draft,
                ];
            })->toArray(),
        ];
    }
}
