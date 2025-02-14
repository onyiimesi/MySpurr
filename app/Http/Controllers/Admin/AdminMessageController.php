<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\Message\AdminMessageService;

class AdminMessageController extends Controller
{
    public function __construct(protected AdminMessageService $messageService)
    {}

    public function sendMessage(Request $request)
    {
        return $this->messageService->sendMessage($request);
    }

    // Talents
    public function talentBroadcastMessage(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|integer',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        return $this->messageService->talentBroadcastMessage($request);
    }

    public function talentMessages()
    {
        return $this->messageService->talentMessages();
    }

    public function talentMessageDetails($id)
    {
        return $this->messageService->talentMessageDetails($id);
    }

    public function updateTalentMessage(Request $request, $id)
    {
        return $this->messageService->updateTalentMessage($request, $id);
    }

    public function deleteTalentMessage($id)
    {
        return $this->messageService->deleteTalentMessage($id);
    }

    // Business
    public function businessBroadcastMessage(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|integer',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        return $this->messageService->businessBroadcastMessage($request);
    }

    public function businessMessages()
    {
        return $this->messageService->businessMessages();
    }

    public function businessMessageDetails($id)
    {
        return $this->messageService->businessMessageDetails($id);
    }

    public function updateBusinessMessage(Request $request, $id)
    {
        return $this->messageService->updateBusinessMessage($request, $id);
    }

    public function deleteBusinessMessage($id)
    {
        return $this->messageService->deleteBusinessMessage($id);
    }
}
