<?php

namespace App\Observers;

use App\Mail\v1\TalentVerifyEmail;
use App\Models\V1\Talent;
use App\Services\Others\EmailSender;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class TalentObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Talent "created" event.
     */
    public function created(Talent $talent): void
    {
        Mail::to($talent->email)->send(new TalentVerifyEmail($talent));

        if(App::environment('production')) {
            $data = (object)[
                'first_name' => $talent->first_name,
                'last_name' => $talent->last_name,
                'email' => $talent->email,
                'phone_number' => $talent->phone_number,
            ];

            (new EmailSender($data))->run();
        }
    }

    /**
     * Handle the Talent "updated" event.
     */
    public function updated(Talent $talent): void
    {
        //
    }

    /**
     * Handle the Talent "deleted" event.
     */
    public function deleted(Talent $talent): void
    {
        //
    }

    /**
     * Handle the Talent "restored" event.
     */
    public function restored(Talent $talent): void
    {
        //
    }

    /**
     * Handle the Talent "force deleted" event.
     */
    public function forceDeleted(Talent $talent): void
    {
        //
    }
}
