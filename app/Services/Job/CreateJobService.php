<?php

namespace App\Services\Job;

use App\Models\V1\Business;
use App\Models\V1\Question;
use App\Models\V1\TalentJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateJobService {

    public $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function run()
    {
        $user = Auth::user();
        $business = Business::where('email', $user->email)->first();

        try {
            
            $data = new TalentJob();

            $data->business_id = $business->id;
            $data->job_title = $this->job->job_title;
            $data->slug = Str::slug($this->job->job_title);
            $data->country_id = $this->job->country_id;
            $data->state_id = $this->job->state_id;
            $data->job_type = $this->job->job_type;
            $data->description = $this->job->description;
            $data->responsibilities = $this->job->responsibilities;
            $data->required_skills = $this->job->required_skills;
            $data->benefits = $this->job->benefits;
            $data->salaray_type = $this->job->salaray_type;
            $data->salary_min = $this->job->salary_min;
            $data->salary_max = $this->job->salary_max;
            $data->currency = $this->job->currency;
            $data->skills = $this->job->skills;
            $data->experience = $this->job->experience;
            $data->qualification = $this->job->qualification;
            $data->status = 'active';
            $data->save();

            foreach ($this->job->questions as $questionData) {
                $question = new Question($questionData);
                $data->questions()->save($question);
            }

        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }
}
