<?php

namespace App\Http\Resources\V1;

use App\Models\V1\TalentJob;
use App\Services\CountryState\CountryDetailsService;
use App\Services\CountryState\StateDetailsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookMarkJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $country = (new CountryDetailsService($this->talentjob->first()->country_id))->run();
        $state = (new StateDetailsService($this->talentjob->first()->country_id, $this->talentjob->first()->state_id))->run();
        $currentDateTime = Carbon::now();
        $sevenDaysAgo = $currentDateTime->subDays(7);

        $total_open = TalentJob::where('status', 'active')->count();
        $total_complete = TalentJob::where('status', 'completed')->count();
        $total_hire = TalentJob::where('status', 'hired')->count();

        return [
            'id' => (string)$this->id,
            'job' => $this->talentjob->map(function ($job)
                use($country, $state, $sevenDaysAgo, $total_open, $total_complete, $total_hire) {
                return [
                    'job_id' => (string)$this->id,
                    'job_title' => (string)$job->job_title,
                    'slug' => (string)$job->slug,
                    'country' => (string)$country->name,
                    'state' => (string)$state->name,
                    'job_type' => (string)$job->job_type,
                    'description' => (string)$job->description,
                    'responsibilities' => (string)$job->responsibilities,
                    'required_skills' => (string)$job->required_skills,
                    'benefits' => (string)$job->benefits,
                    'salaray_type' => (string)$job->salaray_type,
                    'salary_min' => (string)$job->salary_min,
                    'salary_max' => (string)$job->salary_max,
                    'currency' => (string)$job->currency,
                    'skills' => (array)$job->skills,
                    'experience' => (string)$job->experience,
                    'qualification' => (string)$job->commitment,
                    'applicants' => $job->jobapply->groupBy(['talent_id'])->count(),
                    'recent_applicants' => $job->jobapply->where('created_at', '>=', $sevenDaysAgo)->groupBy('talent_id')->count(),
                    'is_bookmark' => (string)$this->is_bookmark,
                    'is_highlighted' => (string)$this->is_highlighted,
                    'status' => (string)$job->status,
                    'date_created' => Carbon::parse($job->created_at)->format('j M Y'),
                    'questions' => $job->questions->map(function($quest) {
                        return [
                            'question' => $quest->question
                        ];
                    }),
                    'company' => (object) [
                        'business_name' => $job->business->business_name,
                        'industry' => (array)$job->business->industry,
                        'about_business' => $job->business->about_business,
                        'company_logo' => $job->business->company_logo,
                    ],
                    'total_opened_jobs' => $total_open,
                    'completed_jobs' => $total_complete,
                    'hired_jobs' => $total_hire
                ];
            })->toArray(),
        ];
    }
}
