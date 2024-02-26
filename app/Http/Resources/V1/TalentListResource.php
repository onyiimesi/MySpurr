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
            'portfolio' => $this->portfolios->map(function($port) {
                return [
                    'id' => $port->id,
                    'title' => $port->title,
                    'client_name' => $port->client_name,
                    'job_type' => $port->job_type,
                    'location' => $port->location,
                    'max_rate' => $port->max_rate,
                    'min_rate' => $port->min_rate,
                    'tags' => json_decode($port->tags),
                    'cover_image' => $port->cover_image,
                    'body' =>  $port->body
                ];
            })->toArray(),
        ];
    }
}
