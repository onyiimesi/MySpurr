<?php

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Events\V1\MessagingEvent;
use App\Http\Resources\V1\MessageResource;
use App\Models\V1\Message;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;


class MessageController extends Controller
{

    public function __construct(private MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function index(Request $request, ?int $receiverId = null)
    {
        $messages = empty($receiverId) ? [] : $this->messageRepository->getMessages($request->user()->id, $receiverId);

        if(!empty($receiverId)){
            Message::where('sender_id', $request->user()->id)->update([
                'status' => 'read'
            ]);
        }

        $msg = MessageResource::collection($messages);

        return [
            'status' => 'true',
            'message' => '',
            'data' => $msg
        ];
    }

    public function store(Request $request, ?int $receiverId)
    {
        $request->validate([
            'message' => ['required']
        ]);

        if(empty($receiverId)){
            return;
        }

        try {

            $message = $this->messageRepository->sendMessage([
                'sender_id' => $request->user()->id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'status' => 'unread'
            ]);

            event(new MessagingEvent($message, $request->user()->id, $request->receiver_id));

            return [
                'status' => 'true',
                'message' => 'Message sent successfully'
            ];

        } catch (\Throwable $th) {

            return [
                'status' => 'false',
                'message' => $th->getMessage()
            ];

        }

    }
}
