<?php

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Events\V1\MessagingEvent;
use App\Http\Resources\V1\MessageResource;
use App\Http\Resources\V1\TalentReceivedMessageResource;
use App\Http\Resources\V1\TalentSentMessageResource;
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

    public function store(Request $request)
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

        $receiverType = Talent::where('email', $request->to)->exists() ? Talent::class : Business::class;
        $receiver = $receiverType::where('email', $request->to)->first();

        if (!$receiver) {
            return $this->error(null, 404, "Receiver not found!");
        }

        try {

            if ($request->attachments) {
                $attachments = [];
                foreach ($request->attachments as $attachment) {
                    $file = $attachment['file'];
                    if($file){
                        $folderName = config('services.message_attachment.base_url');
                        $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                        $replace = substr($file, 0, strpos($file, ',')+1);
                        $sig = str_replace($replace, '', $file);
                        $sig = str_replace(' ', '+', $sig);
                        $file_name = time().'.'.$extension;
                        $path = public_path().'/attachments/'.$file_name;

                        // Ensure the directory exists
                        if (!file_exists(public_path().'/attachments')) {
                            mkdir(public_path().'/attachments', 0777, true);
                        }

                        $success = file_put_contents($path, base64_decode($sig));
                        if ($success === false) {
                            throw new \Exception("Failed to write file to disk.");
                        }
                        $pathss = $folderName.'/'.$file_name;
                        $attachments[] = ['path' => $pathss];

                        $attachments = json_encode($attachments);
                    }else{
                        $attachments = NULL;
                    }
                }
            }

            $message = $this->messageRepository->sendMessage([
                'sender_id' => $request->sender_id,
                'sender_type' => auth()->user() instanceof Business ? Business::class : Talent::class,
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

            event(new MessagingEvent($message, $request->sender_id, $request->to));

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

    public function talentsentmsgs()
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)->first();

        if(!$talent){
            return $this->error(null, 404, "User not found!");
        }

        $messages = TalentSentMessageResource::collection($talent->sentMessages);

        return $this->success($messages, "All Sent messages", 200);
    }

    public function msgdetail($id)
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)->first();

        if(!$talent){
            return $this->error(null, 404, "User not found!");
        }

        $message = $talent->sentMessages()->where('id', $id)->first();

        if(!$message){
            return $this->error(null, 404, "Not found!");
        }

        if($message->status == "unread"){
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
        $talent = Talent::where('id', $user->id)->first();

        if(!$talent){
            return $this->error(null, 404, "User not found!");
        }

        $messages = TalentReceivedMessageResource::collection($talent->receivedMessages);

        return $this->success($messages, "All Received messages", 200);
    }

    public function msgdetailreceived($id)
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)->first();

        if(!$talent){
            return $this->error(null, 404, "User not found!");
        }

        $message = $talent->receivedMessages()->where('id', $id)->first();

        if(!$message){
            return $this->error(null, 404, "Not found!");
        }

        if($message->status == "unread"){
            $message->update([
                'status' => 'read'
            ]);
        }

        $msg = new TalentReceivedMessageResource($message);

        return $this->success($msg, "Received message detail", 200);
    }
}
