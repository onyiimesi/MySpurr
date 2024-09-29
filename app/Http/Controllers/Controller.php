<?php

namespace App\Http\Controllers;

use App\Actions\SendMailAction;
use App\Enum\UserStatus;
use App\Mail\v1\AccountSuspendMail;
use App\Mail\v1\AccountWarningMail;
use App\Mail\v1\event\TestEventCanceledMail;
use App\Mail\v1\event\TestEventPostponedMail;
use App\Mail\v1\event\TestEventRegisterMail;
use App\Mail\v1\event\TestEventReminderMail;
use App\Mail\v1\TestBusinessApplicationMail;
use App\Mail\v1\TestJobSuggestionMail;
use App\Mail\v1\TestTalentApplyMail;
use App\Models\Admin\Event;
use App\Models\V1\Business;
use App\Models\V1\JobApply;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function Illuminate\Support\defer;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getUser()
    {
        return Auth::user();
    }

    protected function business($email)
    {
        $jobApplication = JobApply::inRandomOrder()->first();

        $talent = Talent::with('certificates')
            ->inRandomOrder()
            ->first();

        $job = TalentJob::with('business')
            ->inRandomOrder()
            ->first();

        Mail::to($email)
        ->send(new TestBusinessApplicationMail($jobApplication, $talent, $job->business, $job));

        return response()->json([
            'status' => true,
            'message' => "Mail sent!"
        ], 200);
    }

    protected function talent($email)
    {
        $talent = Talent::inRandomOrder()->first();
        $jobApplication = JobApply::inRandomOrder()->first();
        $job = TalentJob::with('business')
            ->inRandomOrder()
            ->first();

        $jobs = TalentJob::with(['jobapply', 'business', 'questions'])
        ->where('status', 'active')
        ->orderBy('is_highlighted', 'desc')
        ->orderBy('created_at', 'desc')
        ->take(2)
        ->get();

        Mail::to($email)
        ->send(new TestTalentApplyMail($jobApplication, $talent, $job->business, $job, $jobs));

        return response()->json([
            'status' => true,
            'message' => "Mail sent!"
        ], 200);
    }

    protected function job($email)
    {
        $talent = Talent::inRandomOrder()->first();

        $jobs = TalentJob::with(['jobapply', 'business', 'questions'])
            ->where('status', 'active')
            ->inRandomOrder()
            ->orderBy('is_highlighted', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        if ($jobs->isNotEmpty()) {
            Mail::to($email)
                ->send(new TestJobSuggestionMail($talent, $jobs));
        }

        return response()->json([
            'status' => true,
            'message' => "Mail sent!"
        ], 200);
    }

    protected function eventReminder($email)
    {
        $user = Talent::inRandomOrder()->first();
        $event = Event::inRandomOrder()->first();

        if(!$event){
            return response()->json([
                'status' => true,
                'message' => "No event found"
            ], 404);
        }

        $action = new TestEventReminderMail($event, $user);

        try {
            (new SendMailAction($email, $action))->run();
        } catch (\Throwable $e) {
            throw $e;
        }

        return response()->json([
            'status' => true,
            'message' => "Mail sent!"
        ], 200);
    }

    protected function eventRegister($email)
    {
        $user = Talent::inRandomOrder()->first();
        $event = Event::inRandomOrder()->first();

        if(!$event){
            return response()->json([
                'status' => true,
                'message' => "No event found"
            ], 404);
        }

        $action = new TestEventRegisterMail($event, $user);

        try {
            (new SendMailAction($email, $action))->run();
        } catch (\Throwable $e) {
            throw $e;
        }

        return response()->json([
            'status' => true,
            'message' => "Mail sent!"
        ], 200);
    }

    protected function eventCanceled($email)
    {
        $user = Talent::inRandomOrder()->first();
        $event = Event::inRandomOrder()->first();

        if(!$event){
            return response()->json([
                'status' => true,
                'message' => "No event found"
            ], 404);
        }

        $setting = (object)[
            'title' => "Event Canceled",
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
        ];

        $action = new TestEventCanceledMail($event, $user, $setting);

        try {
            (new SendMailAction($email, $action))->run();
        } catch (\Throwable $e) {
            throw $e;
        }

        return response()->json([
            'status' => true,
            'message' => "Mail sent!"
        ], 200);
    }

    protected function eventPostPoned($email)
    {
        $user = Talent::inRandomOrder()->first();
        $event = Event::inRandomOrder()->first();

        if(!$event){
            return response()->json([
                'status' => true,
                'message' => "No event found"
            ], 404);
        }

        $setting = (object)[
            'title' => "Event Postponed",
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
        ];

        $action = new TestEventPostponedMail($event, $user, $setting);

        try {
            (new SendMailAction($email, $action))->run();
        } catch (\Throwable $e) {
            throw $e;
        }

        return response()->json([
            'status' => true,
            'message' => "Mail sent!"
        ], 200);
    }

    protected function warningTalentEmail($request)
    {
        $user = Talent::where('email', $request->email)
        ->firstOrFail();

        sendMail($request->email, new AccountWarningMail($user));

        return $this->success(null, 'Mail sent');
    }

    protected function warningBusinessEmail($request)
    {
        $user = Business::where('email', $request->email)
        ->firstOrFail();

        sendMail($request->email, new AccountWarningMail($user));

        return $this->success(null, 'Mail sent');
    }

    protected function suspendTalent($request)
    {
        $user = Talent::where('email', $request->email)
        ->firstOrFail();

        $user->update([
            'status' => UserStatus::SUSPENDED,
        ]);

        sendMail($request->email, new AccountSuspendMail($user));

        return $this->success(null, 'User suspended successfully');
    }

    protected function suspendBusiness($request)
    {
        $user = Business::where('email', $request->email)
        ->firstOrFail();

        $user->update([
            'status' => UserStatus::SUSPENDED,
        ]);

        sendMail($request->email, new AccountSuspendMail($user));

        return $this->success(null, 'User suspended successfully');
    }

    protected function reactivateTalent($request)
    {
        $user = Talent::where('email', $request->email)
        ->firstOrFail();

        $user->update([
            'status' => UserStatus::ACTIVE,
        ]);

        //defer(fn() => sendMail($request->email, new AccountSuspendMail($user)));

        return $this->success(null, 'User reactivated successfully');
    }

    protected function reactivateBusiness($request)
    {
        $user = Business::where('email', $request->email)
        ->firstOrFail();

        $user->update([
            'status' => UserStatus::ACTIVE,
        ]);

        //defer(fn() => sendMail($request->email, new AccountSuspendMail($user)));

        return $this->success(null, 'User reactivated successfully');
    }
}
