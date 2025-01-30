<?php

namespace App\Services\Admin\Message;

use App\Traits\MessageTrait;
use App\Traits\HttpResponses;
use App\Repositories\MessageRepository;


class AdminMessageService
{
    use HttpResponses, MessageTrait;

    public function __construct(
        private MessageRepository $messageRepository
    )
    {
        $this->messageRepository = $messageRepository;
    }

    public function sendMessage($request)
    {
        $receiverType = $this->determineReceiverType($request->to);
        $receiver = $this->findReceiver($request->to, $receiverType);

        if (!$receiver) {
            return $this->error(null, 404, "Receiver not found!");
        }

        $this->messageRepository->sendMessage([
            'sender_id' => $request->sender_id,
            'sender_type' => $this->determineSenderType(),
            'receiver_id' => $receiver->id,
            'receiver_type' => $receiverType,
            'send_to' => $request->to,
            'subject' => $request->subject,
            'body' => $request->message,
            'is_sent' => 1,
            'sent_at' => now(),
            'status' => 'unread'
        ]);

        return $this->success(null, "Sent successfully", 201);
    }
}



