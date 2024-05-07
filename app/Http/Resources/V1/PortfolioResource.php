<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
            'category_id' => (string)$this->category_id,
            'description' => (string)$this->description,
            'project_image' => (array)$this?->portfolioprojectimage->map(function ($data) {
                return [
                    'id' => $data->id,
                    'image' => $data->image
                ];
            })->toArray(),
            'tags' => json_decode($this->tags),
            'link' => $this->link,
            'featured_image' => $this->featured_image,
            'is_draft' =>  $this->is_draft,
            'user_details' => (object) [
                'first_name' => $this->talent?->first_name,
                'last_name' => $this->talent?->last_name,
                'email' => $this->talent?->email
            ],
            'created_at' => Carbon::parse($this->created_at)->format('d M Y')
        ];
    }
}
