<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            'title' => (string)$this->title,
            'slug' => (string)$this->slug,
            'description' => (string)$this->description,
            'content' => (string)$this->content,
            'tags' => json_decode($this->tags),
            'featured_photo' => (string)$this->featured_photo,
            'publish_date' => Carbon::parse($this->publish_date)->format('d M Y h:i A'),
            'status' => (string)$this->status
        ];
    }
}
