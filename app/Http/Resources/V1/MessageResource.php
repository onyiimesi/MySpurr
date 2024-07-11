<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
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
            'id' => (int)$this->id,
            'sender_id' => (int)$this->sender_id,
            'subject' => (string)$this->subject,
            'message' => (string)$this->body,
            'cc' => (string)$this->cc,
            'bcc' => (string)$this->bcc,
            'attachment' => (string)$this->attachment,
            'sent_at' => Carbon::parse($this->sent_at)->format('d M Y h:i A'),
            'sender' => (object) [
                'id' => (int)$this->sender->id,
                'first_name' => $this->sender->first_name,
                'last_name' => $this->sender->last_name,
                'email' => $this->sender->email,
            ],
            'receiver_id' => (int)$this->receiver_id,
            'receiver' => (object) [
                'id' => (int)$this->receiver->id,
                'first_name' => $this->receiver->first_name,
                'last_name' => $this->receiver->last_name,
                'email' => $this->receiver->email,
            ],
            'status' => (string)$this->status
        ];
    }
}
