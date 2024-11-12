<?php

namespace App\Http\Controllers\V1;

use App\Actions\SendMailAction;
use App\Http\Controllers\Controller;
use App\Events\V1\MessagingEvent;
use App\Http\Requests\MessageReplyRequest;
use App\Http\Resources\V1\MessageResource;
use App\Http\Resources\V1\TalentReceivedMessageResource;
use App\Http\Resources\V1\TalentSentMessageResource;
use App\Mail\v1\MessageMail;
use App\Models\V1\Business;
use App\Models\V1\Message;
use App\Models\V1\Talent;
use App\Repositories\MessageRepository;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use HttpResponses;

    public function __construct(private MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function index(Request $request, $userId = null)
    {
        $messages = empty($userId) ? [] : $this->messageRepository->getMessages($request->user()->id, $userId);

        if (!empty($userId)) {
            Message::with(['sender', 'receiver'])
                ->where('sender_id', $request->user()->id)
                ->update([
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

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $receiverType = $this->determineReceiverType($request->to);
        $receiver = $this->findReceiver($request->to, $receiverType);

        if (!$receiver) {
            return $this->error(null, 404, "Receiver not found!");
        }

        try {
            $attachments = $this->processAttachments($request->attachments);

            $message = $this->messageRepository->sendMessage([
                'sender_id' => $request->sender_id,
                'sender_type' => $this->determineSenderType(),
                'receiver_id' => $receiver->id,
                'receiver_type' => $receiverType,
                'send_to' => $request->to,
                'subject' => $request->subject,
                'body' => $request->body,
                'cc' => $request->cc,
                'bcc' => $request->bcc,
                'attachment' => $attachments,
                'is_sent' => 1,
                'sent_at' => Carbon::now(),
                'status' => 'unread'
            ]);

            // event(new MessagingEvent($message, $request->sender_id, $request->to));

            (new SendMailAction($request->to, new MessageMail($message)))->run();

            return $this->success(null, "Sent successfully");

        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function editMessage(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        $message->update([
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return $this->success(null, "Updated successfully");
    }

    public function replyMessage(MessageReplyRequest $request)
    {
        $message = Message::with('messageReply')->find($request->message_id);

        if(!$message){
            return $this->error(null, 404, "Message not found!");
        }

        $receiverType = Talent::where('email', $request->receiver_email)->exists() ? Talent::class : Business::class;
        $receiver = $receiverType::where('email', $request->receiver_email)->first();

        if (!$receiver) {
            return $this->error(null, 404, "Receiver not found!");
        }

        try {

            $attachments = $this->processAttachments($request->attachments);

            $message->messageReply()->create([
                'sender_id' => $request->sender_id,
                'sender_type' => $this->determineSenderType(),
                'receiver_id' => $receiver->id,
                'receiver_type' => $receiverType,
                'message' => $request->message,
                'attachment' => $attachments,
                'replied_at' => Carbon::now(),
                'status' => 'unread'
            ]);

            return $this->success(null, "Reply sent");
        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function talentsentmsgs()
    {
        $auth = Auth::user();

        if($auth->type === "talent"){

            $talent = Talent::with(['sentMessages'])
            ->where('id', $auth->id)
            ->first();

            $messagesQuery = $talent->sentMessages()->orderBy('created_at', 'desc');

        } elseif($auth->type === "business"){

            $business = Business::with(['sentMessages'])
            ->where('id', $auth->id)
            ->first();

            $messagesQuery = $business->sentMessages()->orderBy('created_at', 'desc');

        } else {
            return $this->error(null, 404, "User not found!");
        }

        $paginatedMessages = $messagesQuery->paginate(25);
        $messages = TalentSentMessageResource::collection($paginatedMessages);

        return [
            'status' => 'true',
            'message' => 'All Sent messages',
            'data' => $messages,
            'pagination' => [
                'current_page' => $paginatedMessages->currentPage(),
                'last_page' => $paginatedMessages->lastPage(),
                'per_page' => $paginatedMessages->perPage(),
                'prev_page_url' => $paginatedMessages->previousPageUrl(),
                'next_page_url' => $paginatedMessages->nextPageUrl()
            ],
        ];
    }

    public function msgdetail($id)
    {
        $message = Message::with('messageReply')->find($id);

        if (!$message) {
            return $this->error(null, 404, "Not found!");
        }

        if ($message->status === "unread") {
            $message->update([
                'status' => 'read'
            ]);
        }

        $msg = new TalentSentMessageResource($message);

        return $this->success($msg, "Sent message detail", 200);
    }

    public function talentreceivedmsgs()
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)
            ->first()
            ->receivedMessages()
            ->paginate(25);

        if (!$talent) {
            return $this->error(null, 404, "User not found!");
        }

        $messages = TalentReceivedMessageResource::collection($talent);

        return [
            'status' => 'true',
            'message' => 'All Received messages',
            'data' => $messages,
            'pagination' => [
                'current_page' => $talent->currentPage(),
                'last_page' => $talent->lastPage(),
                'per_page' => $talent->perPage(),
                'prev_page_url' => $talent->previousPageUrl(),
                'next_page_url' => $talent->nextPageUrl(),
            ],
        ];
    }

    public function msgdetailreceived($id)
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)->first();

        if (!$talent) {
            return $this->error(null, 404, "User not found!");
        }

        $message = $talent->receivedMessages()->where('id', $id)->first();

        if (!$message) {
            return $this->error(null, 404, "Not found!");
        }

        if ($message->status == "unread") {
            $message->update([
                'status' => 'read'
            ]);
        }

        $msg = new TalentReceivedMessageResource($message);

        return $this->success($msg, "Received message detail", 200);
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'sender_id' => 'required',
            'to' => 'required|email',
            'cc' => 'nullable|email',
            'bcc' => 'nullable|email',
            'subject' => 'required|string',
            'body' => 'required|string',
            'attachments' => 'nullable|array'
        ]);
    }

    private function determineReceiverType($email)
    {
        return Talent::where('email', $email)->exists() ? Talent::class : Business::class;
    }

    private function findReceiver($email, $receiverType)
    {
        return $receiverType::where('email', $email)->first();
    }

    private function determineSenderType()
    {
        return auth()->user() instanceof Business ? Business::class : Talent::class;
    }

    private function processAttachments($attachments)
    {
        if (!$attachments) {
            return null;
        }

        $processedAttachments = [];
        foreach ($attachments as $attachment) {
            $filePath = $this->storeAttachment($attachment['file']);
            if ($filePath) {
                $processedAttachments[] = [
                    'file' => $filePath,
                    'file_name' => $attachment['file_name'],
                    'file_size' => $attachment['file_size']
                ];
            }
        }

        return json_encode($processedAttachments);
    }

    private function storeAttachment($file)
    {
        if (!$file) {
            return null;
        }

        $folderName = config('services.message_attachment.base_url');
        $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
        $replace = substr($file, 0, strpos($file, ',') + 1);
        $sig = str_replace($replace, '', $file);
        $sig = str_replace(' ', '+', $sig);
        $fileName = time() . '.' . $extension;
        $path = public_path() . '/attachments/' . $fileName;

        if (!file_exists(public_path() . '/attachments')) {
            mkdir(public_path() . '/attachments', 0777, true);
        }

        $success = file_put_contents($path, base64_decode($sig));
        if ($success === false) {
            throw new \Exception("Failed to write file to disk.");
        }

        return $folderName . '/' . $fileName;
    }
}
