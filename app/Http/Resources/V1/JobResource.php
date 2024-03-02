<?php

namespace App\Http\Resources\V1;

use App\Services\CountryState\CountryDetailsService;
use App\Services\CountryState\StateDetailsService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $country = (new CountryDetailsService($this->country_id))->run();
        $state = (new StateDetailsService($this->country_id, $this->state_id))->run();
        $currentDateTime = Carbon::now();
        $sevenDaysAgo = $currentDateTime->subDays(7);

        return [
            'id' => (string)$this->id,
            'job_title' => (string)$this->job_title,
            'slug' => (string)$this->slug,
            'country' => (string)$country->name,
            'state' => (string)$state->name,
            'job_type' => (string)$this->job_type,
            'description' => (string)$this->description,
            'responsibilities' => (string)$this->responsibilities,
            'required_skills' => (string)$this->required_skills,
            'benefits' => (string)$this->benefits,
            'salaray_type' => (string)$this->salaray_type,
            'salary_min' => (string)$this->salary_min,
            'salary_max' => (string)$this->salary_max,
            'currency' => (string)$this->currency,
            'skills' => (array)$this->skills,
            'experience' => (string)$this->experience,
            'qualification' => (string)$this->commitment,
            'applicants' => $this->jobapply->groupBy(['talent_id'])->count(),
            'recent_applicants' => $this->jobapply->where('created_at', '>=', $sevenDaysAgo)->groupBy('talent_id')->count(),
            'status' => (string)$this->status,
            'date_created' => Carbon::parse($this->created_at)->format('j M Y'),
            'questions' => $this->questions->map(function($quest) {
                return [
                    'question' => $quest->question
                ];
            }),
            'company' => (object) [
                'business_name' => $this->business->business_name,
                'industry' => $this->business->industry,
                'about_business' => $this->business->about_business,
                'company_logo' => $this->business->company_logo,
            ],
            'total_opened_jobs' => 10,
            'completed_jobs' => 5,
            'hired_jobs' => 2
        ];
    }
}
