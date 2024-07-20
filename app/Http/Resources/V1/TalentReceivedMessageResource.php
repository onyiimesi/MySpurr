<?php

namespace App\Http\Resources\V1;

use App\Models\V1\Business;
use App\Models\V1\Talent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentReceivedMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->sender_type === "App\Models\V1\Business"){
            $sender = Business::findorFail($this->sender_id);
        }else {
            $sender = Talent::findorFail($this->sender_id);
        }

        if($this->receiver_type === "App\Models\V1\Business"){
            $receiver = Business::findorFail($this->receiver_id);
        }else {
            $receiver = Talent::findorFail($this->receiver_id);
        }

        return [
            'id' => (string)$this->id,
            'attributes' => [
                'sender_id' => (string)$this->sender_id,
                'sender' => (object) [
                    'id' => $sender->id,
                    'first_name' => $sender->first_name,
                    'last_name' => $sender->last_name,
                    'email' => $sender->email
                ],
                'receiver_id' => (string)$this->receiver_id,
                'receiver' => (object) [
                    'id' => $receiver->id,
                    'first_name' => $receiver->first_name,
                    'last_name' => $receiver->last_name,
                    'email' => $receiver->email
                ],
                'send_to' => (string)$this->send_to,
                'subject' => (string)$this->subject,
                'body' => (string)$this->body,
                'cc' => (string)$this->cc,
                'bcc' => (string)$this->bcc,
                'attachment' => (array)json_decode($this->attachment),
                'is_draft' => (string)$this->is_draft,
                'is_sent' => (string)$this->is_sent,
                'sent_at' => Carbon::parse($this->sent_at)->format('d M Y'),
                'status' => (string)$this->status
            ]
        ];
    }
}
