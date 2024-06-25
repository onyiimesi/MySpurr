<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\v1\TestBusinessApplicationMail;
use App\Mail\v1\TestJobSuggestionMail;
use App\Mail\v1\TestTalentApplyMail;
use App\Models\V1\JobApply;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'email:rfc,dns'],
            'type' => ['required', 'in:business_application,talent_apply,job_suggestion']
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

            default:
                return "Not found!";
                break;
        }
    }

    private function business($email)
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

    private function talent($email)
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

    private function job($email)
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
}
