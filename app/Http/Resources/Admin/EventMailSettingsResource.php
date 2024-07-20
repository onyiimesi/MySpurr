<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventMailSettingsResource extends JsonResource
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
            'event_id' => (string)$this->event_id,
            'type' => (string)$this->type,
            'date' => (string)$this->date,
            'title' => (string)$this->title,
            'description' => (string)$this->description
        ];
    }
}
