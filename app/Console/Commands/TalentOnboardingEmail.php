<?php

namespace App\Console\Commands;

use App\Models\V1\Talent;
use Illuminate\Console\Command;

class TalentOnboardingEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'talent-onboarding:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send onboarding email to talents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Talent::chunk(30, function ($talents) {
            foreach ($talents as $talent) {
                $talent->sendOnboardingEmail();
            }
        });
    }
}
