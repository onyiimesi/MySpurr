<?php

namespace App\Services\Job;

use App\Enum\TalentJobType;
use App\Mail\v1\JobInvoiceMail;
use App\Models\V1\Business;
use App\Models\V1\Question;
use App\Models\V1\TalentJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateJobService {

    protected $job;
    protected $email;
    protected $highlight;
    protected $type;
    protected $payment;

    public function __construct($job, $email, $highlight, $type, $payment)
    {
        $this->job = $job;
        $this->email = $email;
        $this->highlight = $highlight;
        $this->type = $type;
        $this->payment = $payment;
    }

    public function run()
    {
        $business = Business::where('email', $this->email)->first();

        try {
            $data = new TalentJob();

            $data->business_id = $business->id;
            $data->job_title = $this->job['job_title'];
            $data->slug = Str::slug($this->job['job_title']);
            $data->country_id = $this->job['country_id'];
            $data->state_id = $this->job['state_id'];
            $data->job_type = $this->job['job_type'];
            $data->description = $this->job['description'];
            $data->responsibilities = $this->job['responsibilities'];
            $data->required_skills = $this->job['required_skills'];
            $data->benefits = $this->job['benefits'];
            $data->salaray_type = $this->job['salaray_type'];
            $data->salary_min = $this->job['salary_min'];
            $data->salary_max = $this->job['salary_max'];
            $data->currency = $this->job['currency'];
            $data->skills = $this->job['skills'];
            $data->experience = $this->job['experience'];
            $data->qualification = $this->job['qualification'];
            $data->is_highlighted = $this->highlight;
            $data->status = 'active';
            $data->save();

            foreach ($this->job['questions'] as $questionData) {
                $question = new Question($questionData);
                $data->questions()->save($question);
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        $business->talentjobtypes()->update(['is_active' => 0]);

        if ($this->type === TalentJobType::PREMIUM) {
            $talentJobType = $business->talentjobtypes()->where('type', TalentJobType::PREMIUM)->first();

            if ($talentJobType) {
                $talentJobType->update([
                    'is_active' => 1,
                    'attempt' => $talentJobType->attempt + 1
                ]);
            } else {
                $business->talentjobtypes()->create([
                    'type' => $this->type,
                    'attempt' => 1,
                    'is_active' => 1
                ]);
            }
        }

        Mail::to($this->email)->send(new JobInvoiceMail($business, $this->payment, $data));
    }
}
