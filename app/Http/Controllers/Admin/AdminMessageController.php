<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\Message\AdminMessageService;

class AdminMessageController extends Controller
{
    public function __construct(
        protected AdminMessageService $messageService
    )
    {
        $this->messageService = $messageService;
    }

    public function sendMessage(Request $request)
    {
        $this->messageService->sendMessage($request);
    }
}
