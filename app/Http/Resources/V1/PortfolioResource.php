<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => (string)$this->title,
            'client_name' => (string)$this->client_name,
            'job_type' => (string)$this->job_type,
            'location' => (string)$this->location,
            'rate' => $this->rate,
            'tags' => json_decode($this->tags),
            'cover_image' => $this->cover_image,
            'body' =>  $this->body
        ];
    }
}
