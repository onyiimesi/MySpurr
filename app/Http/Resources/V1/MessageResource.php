<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sender_id' => (string)$this->sender_id,
            'sender' => new TalentResource($this->sender),
            'receiver_id' => (string)$this->receiver_id,
            'receiver' => new TalentResource($this->receiver),
            'message' => (string)$this->message,
            'status' => (string)$this->status
        ];
    }
}
