<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BusinessReceivedMessageResource;
use App\Http\Resources\V1\BusinessSentMessageResource;
use App\Models\V1\Business;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessMessageController extends Controller
{
    use HttpResponses;

    public function sentmsgs()
    {
        $user = Auth::user();
        $business = Business::where('id', $user->id)
        ->first()
        ->sentMessages()
        ->paginate(25);

        if(!$business){
            return $this->error(null, 404, "User not found!");
        }

        $messages = BusinessSentMessageResource::collection($business);

        return [
            'status' => 'true',
            'message' => 'All Sent messages',
            'data' => $messages,
            'pagination' => [
                'current_page' => $business->currentPage(),
                'last_page' => $business->lastPage(),
                'per_page' => $business->perPage(),
                'prev_page_url' => $business->previousPageUrl(),
                'next_page_url' => $business->nextPageUrl(),
            ],
        ];
    }

    public function msgdetail($id)
    {
        $user = Auth::user();
        $business = Business::where('id', $user->id)->first();

        if(!$business){
            return $this->error(null, 404, "User not found!");
        }

        $message = $business->sentMessages()->where('id', $id)->first();

        if(!$message){
            return $this->error(null, 404, "Not found!");
        }

        if($message->status == "unread"){
            $message->update([
                'status' => 'read'
            ]);
        }

        $msg = new BusinessSentMessageResource($message);

        return $this->success($msg, "Sent message detail", 200);
    }

    public function receivedmsgs()
    {
        $user = Auth::user();
        $business = Business::where('id', $user->id)
        ->first()
        ->receivedMessages()
        ->paginate(25);

        if(!$business){
            return $this->error(null, 404, "User not found!");
        }

        $messages = BusinessReceivedMessageResource::collection($business);

        return [
            'status' => 'true',
            'message' => 'All Received messages',
            'data' => $messages,
            'pagination' => [
                'current_page' => $business->currentPage(),
                'last_page' => $business->lastPage(),
                'per_page' => $business->perPage(),
                'prev_page_url' => $business->previousPageUrl(),
                'next_page_url' => $business->nextPageUrl(),
            ],
        ];
    }

    public function msgdetailreceived($id)
    {
        $user = Auth::user();
        $business = Business::where('id', $user->id)->first();

        if(!$business){
            return $this->error(null, 404, "User not found!");
        }

        $message = $business->receivedMessages()->where('id', $id)->first();

        if(!$message){
            return $this->error(null, 404, "Not found!");
        }

        if($message->status == "unread"){
            $message->update([
                'status' => 'read'
            ]);
        }

        $msg = new BusinessReceivedMessageResource($message);

        return $this->success($msg, "Received message detail", 200);
    }
}
