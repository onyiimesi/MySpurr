<?php

namespace App\Console\Commands;

use App\Mail\v1\JobSuggestionMail;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use Illuminate\Console\Command;
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
        $talents = Talent::where('status', 'active')->get();

        foreach ($talents as $talent) {
            $jobs = TalentJob::with(['jobapply', 'business', 'questions'])
                ->where('status', 'active')
                ->inRandomOrder()
                ->orderBy('is_highlighted', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            if ($jobs->isNotEmpty()) {
                Mail::to([$talent->email])
                    ->send(new JobSuggestionMail($talent, $jobs));
            }
        }
    }
}
