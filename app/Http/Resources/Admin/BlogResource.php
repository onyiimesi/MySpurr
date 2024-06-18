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
            'tags' => $this->getTagsAsArray(),
            'featured_photo' => (string)$this->featured_photo,
            'publish_date' => (string)$this->publish_date,
            'publish_date_view' => Carbon::parse($this->publish_date)->format('d M Y h:i A'),
            'status' => (string)$this->status,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y h:i A'),
        ];
    }

    public function getTagsAsArray()
    {
        $tags = $this->tags;

        // First decode
        $decodedOnce = json_decode($tags, true);

        // Check if the first decode result is an array
        if (is_array($decodedOnce)) {
            return $decodedOnce;
        }

        // If the first decode is not an array, try the second decode
        $decodedTwice = json_decode($decodedOnce, true);

        // Check for JSON errors and if the result is an array
        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedTwice)) {
            return $decodedTwice;
        }

        // If decoding fails, return an empty array
        return [];
    }
}
