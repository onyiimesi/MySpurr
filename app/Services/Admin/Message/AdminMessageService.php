<?php

namespace App\Services\Admin\Message;

use App\Http\Resources\Admin\BroadCastMessageResource;
use App\Models\V1\BroadCastMessage;
use App\Models\V1\Business;
use App\Models\V1\Message;
use App\Models\V1\Talent;
use App\Traits\MessageTrait;
use App\Traits\HttpResponses;
use App\Repositories\MessageRepository;
use Illuminate\Support\Facades\DB;

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

    // Talents
    public function talentBroadcastMessage($request)
    {
        try {
            DB::beginTransaction();

            $msg = BroadCastMessage::create([
                'sender_id' => $request->sender_id,
                'subject' => $request->subject,
                'brand' => 'My Spurr',
                'message' => $request->message,
                'type' => 'talent',
                'status' => 'sent'
            ]);

            Talent::chunk(500, function ($talents) use ($request, $msg) {
                foreach ($talents as $talent) {
                    $this->messageRepository->sendMessage([
                        'sender_id' => $request->sender_id,
                        'broad_cast_message_id' => $msg->id,
                        'sender_type' => $this->determineSenderType(),
                        'receiver_id' => $talent->id,
                        'receiver_type' => 'App\Models\V1\Talent',
                        'send_to' => $talent->email,
                        'subject' => $request->subject,
                        'body' => $request->message,
                        'is_sent' => 1,
                        'sent_at' => $request->publish_date,
                        'status' => 'unread',
                        'type' => 'broadcast',
                    ]);
                }
            });

            DB::commit();
            return $this->success(null, "Broadcast sent successfully", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function talentMessages()
    {
        $messages = BroadCastMessage::with('sender')
            ->where('type', 'talent')
            ->paginate(25);

        $data = BroadCastMessageResource::collection($messages);

        return [
            'status' => 'true',
            'message' => 'Broadcast messages',
            'value' => [
                'result' => $data,
                'current_page' => $messages->currentPage(),
                'page_count' => $messages->lastPage(),
                'page_size' => $messages->perPage(),
                'total_records' => $messages->total()
            ]
        ];
    }

    public function talentMessageDetails($id)
    {
        $msg = BroadCastMessage::findOrFail($id);
        $data = new BroadCastMessageResource($msg);

        return [
            'status' => true,
            'message' => "Message Details",
            'value' => $data
        ];
    }

    public function updateTalentMessage($request, $id)
    {
        $msg = BroadCastMessage::findOrFail($id);

        $msg->update([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        Message::where('broad_cast_message_id', $msg->id)
            ->update([
                'subject' => $request->subject,
                'body' => $request->message,
            ]);

        return $this->success(null, "Message updated successfully");
    }

    public function deleteTalentMessage($id)
    {
        $msg = BroadCastMessage::findOrFail($id);
        $msg->delete();

        Message::where('broad_cast_message_id', $msg->id)
            ->delete();

        return $this->success(null, "Message deleted successfully");
    }

    // Business
    public function businessBroadcastMessage($request)
    {
        try {
            DB::beginTransaction();

            $msg = BroadCastMessage::create([
                'sender_id' => $request->sender_id,
                'subject' => $request->subject,
                'brand' => 'My Spurr',
                'message' => $request->message,
                'type' => 'business',
                'status' => 'sent'
            ]);

            Business::chunk(500, function ($businesss) use ($request, $msg) {
                foreach ($businesss as $business) {
                    $this->messageRepository->sendMessage([
                        'sender_id' => $request->sender_id,
                        'broad_cast_message_id' => $msg->id,
                        'sender_type' => $this->determineSenderType(),
                        'receiver_id' => $business->id,
                        'receiver_type' => 'App\Models\V1\Business',
                        'send_to' => $business->email,
                        'subject' => $request->subject,
                        'body' => $request->message,
                        'is_sent' => 1,
                        'sent_at' => $request->publish_date,
                        'status' => 'unread',
                        'type' => 'broadcast',
                    ]);
                }
            });

            DB::commit();
            return $this->success(null, "Broadcast sent successfully", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function businessMessages()
    {
        $messages = BroadCastMessage::with('sender')
            ->where('type', 'business')
            ->paginate(25);

        $data = BroadCastMessageResource::collection($messages);

        return [
            'status' => 'true',
            'message' => 'Broadcast messages',
            'value' => [
                'result' => $data,
                'current_page' => $messages->currentPage(),
                'page_count' => $messages->lastPage(),
                'page_size' => $messages->perPage(),
                'total_records' => $messages->total()
            ]
        ];
    }

    public function businessMessageDetails($id)
    {
        $msg = BroadCastMessage::findOrFail($id);
        $data = new BroadCastMessageResource($msg);

        return [
            'status' => true,
            'message' => "Message Details",
            'value' => $data
        ];
    }

    public function updateBusinessMessage($request, $id)
    {
        $msg = BroadCastMessage::findOrFail($id);

        $msg->update([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        Message::where('broad_cast_message_id', $msg->id)
            ->update([
                'subject' => $request->subject,
                'body' => $request->message,
            ]);

        return $this->success(null, "Message updated successfully");
    }

    public function deleteBusinessMessage($id)
    {
        $msg = BroadCastMessage::findOrFail($id);
        $msg->delete();

        Message::where('broad_cast_message_id', $msg->id)
            ->delete();

        return $this->success(null, "Message deleted successfully");
    }

}



