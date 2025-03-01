<?php

namespace App\Console\Commands;

use App\Enum\UserStatus;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use App\Enum\TalentJobStatus;
use Illuminate\Console\Command;
use App\Mail\v1\JobSuggestionMail;
use Illuminate\Support\Facades\Mail;

class JobSuggestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:job-suggestion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $talents = Talent::where('status', UserStatus::ACTIVE)->get();

        $jobs = TalentJob::with(['jobapply', 'business', 'questions'])
            ->whereStatus(TalentJobStatus::ACTIVE)
            ->inRandomOrder()
            ->orderBy('is_highlighted', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        if ($jobs->isNotEmpty()) {
            foreach ($talents as $talent) {
                Mail::to($talent->email)->send(new JobSuggestionMail($talent, $jobs));
            }
        }
    }

}
