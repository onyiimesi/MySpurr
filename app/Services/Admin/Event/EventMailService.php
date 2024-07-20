<?php

namespace App\Services\Admin\Event;

use App\Actions\SendMailAction;
use App\Mail\v1\EventCanceledMail;
use App\Mail\v1\EventPostponedMail;
use App\Mail\v1\EventReminderMail;
use App\Models\Admin\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventMailService
{
    public function eventEmail()
    {
        $date = Carbon::now()->format('Y-m-d');

        $events = Event::with(['eventMailSetting', 'registeredEvents'])
            ->where('status', 'active')
            ->whereDate('event_date', '>=', $date)
            ->get();

        foreach ($events as $event) {
            $setting = $event->eventMailSetting()->where('date', $date)->first();

            if ($setting) {
                foreach ($event->registeredEvents as $user) {
                    switch ($setting->type) {
                        case 'reminder':
                            $action = new EventReminderMail($event, $user);
                            break;

                        case 'canceled':
                            $action = new EventCanceledMail($event, $user, $setting);
                            break;

                        case 'postponed':
                            $action = new EventPostponedMail($event, $user, $setting);
                            break;

                        default:
                            continue 2; // Skip to the next user if the type is not found
                    }

                    $this->mail($user->email, $action);
                }
            }
        }
    }

    private function mail($email, $action)
    {
        try {
            return (new SendMailAction($email, $action))->run();
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$email}: {$e->getMessage()}");
        }
    }
}


