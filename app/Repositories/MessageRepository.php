<?php

namespace App\Repositories;

use App\Models\V1\Message;

class MessageRepository
{
    public function getMessages(int $userId1, int $userId2)
    {
        return Message::where(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId1)
                ->where('receiver_id', $userId2);
        })
            ->orWhere(function ($query) use ($userId1, $userId2) {
                $query->where('sender_id', $userId2)
                    ->where('receiver_id', $userId1);
            })
            ->orWhere(function ($query) use ($userId1) {
                $query->where('sender_id', $userId1)
                    ->orWhere('receiver_id', $userId1);
            })
            ->orWhere(function ($query) use ($userId2) {
                $query->where('sender_id', $userId2)
                    ->orWhere('receiver_id', $userId2);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function sendMessage(array $data)
    {
        return Message::create($data);
    }
}
