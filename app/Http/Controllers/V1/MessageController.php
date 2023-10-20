<?php

namespace App\Http\Controllers\V1;

use App\Events\V1\MessagingEvent;
use App\Http\Controllers\Controller;
use App\Models\V1\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($receiverId)
    {
        $messages = Message::where('receiver_id', $receiverId)
                           ->orWhere('sender_id', $receiverId)
                           ->get();

        return response()->json(['messages' => $messages], 200);
    }

    public function store(Request $request)
    {

        $user = Auth::user();

        try {

            $message = Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'status' => 'unread'
            ]);

            event(new MessagingEvent($message));

            return [
                'status' => 'true',
                'message' => 'Message sent successfully'
            ];

        } catch (\Throwable $th) {
            $th->getMessage();
        }
    }
}
