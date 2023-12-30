<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllPortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => (object) [
                'first_name' => $this->talent->first_name,
                'last_name' => $this->talent->last_name,
            ],
            'id' => $this->id,
            'title' => (string)$this->title,
            'client_name' => (string)$this->client_name,
            'job_type' => (string)$this->job_type,
            'location' => (string)$this->location,
            'max_rate' => $this->max_rate,
            'min_rate' => $this->min_rate,
            'tags' => json_decode($this->tags),
            'cover_image' => $this->cover_image,
            'body' =>  $this->body
        ];
    }
}
