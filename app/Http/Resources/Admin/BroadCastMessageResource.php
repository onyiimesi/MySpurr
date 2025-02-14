<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BroadCastMessageResource extends JsonResource
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
            'sender_id' => $this->sender_id,
            'subject' => $this->subject,
            'brand' => $this->brand,
            'message' => $this->message,
            'status' => $this->status,
            'time' => $this->created_at->format('h:i A'),
            'date' => $this->created_at->format('d/m/Y'),
        ];
    }
}
