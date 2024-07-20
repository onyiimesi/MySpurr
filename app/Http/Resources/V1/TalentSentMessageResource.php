<?php

namespace App\Http\Resources\V1;

use App\Models\V1\MessageReply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentSentMessageResource extends JsonResource
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
            'sender' => (object) [
                'id' => optional($this->sender)->id,
                'first_name' => optional($this->sender)->first_name,
                'last_name' => optional($this->sender)->last_name,
                'email' => optional($this->sender)->email,
            ],
            'receiver' => (object) [
                'id' => optional($this->receiver)->id,
                'first_name' => optional($this->receiver)->first_name,
                'last_name' => optional($this->receiver)->last_name,
                'email' => optional($this->receiver)->email,
            ],
            'subject' => (string)$this->subject,
            'message' => (string)$this->body,
            'cc' => (string)$this->cc,
            'bcc' => (string)$this->bcc,
            'attachment' => (array)$this->attachment,
            'sent_at' => Carbon::parse($this->sent_at)->format('d M Y h:i A'),
            'status' => (string)$this->status,
            'replies' => $this->messageReply ? $this->messageReply->map(function ($reply) {
                $this->updateRead($reply->id);
                return [
                    'sender' => (object) [
                        'id' => (int)$reply->sender->id,
                        'first_name' => $reply->sender->first_name,
                        'last_name' => $reply->sender->last_name,
                        'email' => $reply->sender->email,
                    ],
                    'receiver' => (object) [
                        'id' => (int)$reply->receiver->id,
                        'first_name' => $reply->receiver->first_name,
                        'last_name' => $reply->receiver->last_name,
                        'email' => $reply->receiver->email,
                    ],
                    'message' => $reply->message,
                    'attachments' => $reply->attachments,
                    'replied_at' => Carbon::parse($reply->replied_at)->format('d M Y h:i A'),
                    'status' => $reply->status,
                ];
            })->toArray() : [],

        ];
    }

    private function updateRead($id)
    {
        $reply = MessageReply::findOrFail($id);

        $reply->update([
            'status' => 'read'
        ]);
    }
}
