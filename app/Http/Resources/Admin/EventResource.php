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
            'slug' => (string)$this->slug,
            'speaker_bio' => (string)$this->speaker_bio,
            'speaker' => (string)$this->speaker,
            'speaker_title' => (string)$this->speaker_title,
            'event_time' => (string)$this->event_time,
            'event_date' => Carbon::parse($this->event_date)->format('d M Y'),
            'event_raw_date' => $this->event_date,
            'event_link' => (string)$this->event_link,
            'timezone' => (string)$this->timezone,
            'address' => (string)$this->address,
            'linkedln' => (string)$this->linkedln,
            'content' => (string)$this->content,
            'tags' => $this->getTagsAsArray(),
            'featured_speaker' => isset(json_decode($this->featured_speaker)->url) ?
            (string) json_decode($this->featured_speaker)->url : null,
            'featured_graphics' => isset(json_decode($this->featured_graphics)->url) ?
            (string) json_decode($this->featured_graphics)->url : null,
            'publish_date' => $this->publish_date,
            'status' => $this->status,
            'brand_partners' => $this->eventBrandPartners ? $this->eventBrandPartners->map(function ($partner) {
                return [
                    'image' => $partner->image
                ];

            })->toArray() : [],
            'registration_count' => $this->registeredEvents()->count(),
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
