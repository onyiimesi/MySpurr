<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'speaker_bio' => (string)$this->speaker_bio,
            'speaker' => (string)$this->speaker,
            'event_time' => (string)$this->event_time,
            'event_date' => Carbon::parse($this->event_date)->format('d M Y'),
            'timezone' => (string)$this->timezone,
            'address' => (string)$this->address,
            'linkedln' => (string)$this->linkedln,
            'content' => (string)$this->content,
            'tags' => $this->getTagsAsArray(),
            'featured_speaker' => (string)$this->featured_speaker,
            'featured_graphics' => (string)$this->featured_graphics,
            'publish_date' => $this->publish_date,
            'status' => $this->status,
            'brand_partners' => $this->eventBrandPartners ? $this->eventBrandPartners->map(function ($partner) {
                return [
                    'image' => $partner->image
                ];
                
            })->toArray() : [],
        ];
    }

    private function getTagsAsArray()
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