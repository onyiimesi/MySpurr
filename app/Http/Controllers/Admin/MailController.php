<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'email:rfc,dns'],
            'type' => ['required', 'in:business_application,talent_apply,job_suggestion,event_reminder,event_register,event_canceled,event_postponed']
        ]);

        $email = $request->email;
        $type = $request->type;

        switch ($type) {
            case 'business_application':
                return $this->business($email);
                break;

            case 'talent_apply':
                return $this->talent($email);
                break;

            case 'job_suggestion':
                return $this->job($email);
                break;

            case 'event_reminder':
                return $this->eventReminder($email);
                break;

            case 'event_register':
                return $this->eventRegister($email);
                break;

            case 'event_canceled':
                return $this->eventCanceled($email);
                break;

            case 'event_postponed':
                return $this->eventPostPoned($email);
                break;

            default:
                return "Not found!";
                break;
        }
    }
}
