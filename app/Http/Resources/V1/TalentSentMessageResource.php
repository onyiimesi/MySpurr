<?php

namespace App\Http\Resources\V1;

use App\Models\V1\Business;
use App\Models\V1\MessageReply;
use App\Models\V1\Talent;
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
            'subject' => (string)$this->subject,
            'message' => (string)$this->body,
            'cc' => (string)$this->cc,
            'bcc' => (string)$this->bcc,
            'attachment' => (string)$this->attachment,
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
