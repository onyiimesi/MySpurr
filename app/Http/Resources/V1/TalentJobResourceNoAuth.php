<?php

namespace App\Http\Resources\V1;

use App\Models\V1\JobApply;
use App\Services\CountryState\CountryDetailsService;
use App\Services\CountryState\StateDetailsService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TalentJobResourceNoAuth extends JsonResource
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
            'country' => (string)$country->name,
            'state' => (string)$state->name,
            'job_title' => (string)$this->job_title,
            'slug' => (string)$this->slug,
            'commitment' => (string)$this->commitment,
            'job_type' => (string)$this->job_type,
            'capacity' => (string)$this->capacity,
            'experience' => (string)$this->experience,
            'description' => (string)$this->description,
            'salaray_type' => (string)$this->salaray_type,
            'salary_min' => (string)$this->salary_min,
            'salary_max' => (string)$this->salary_max,
            'currency' => (string)$this->currency,
            'applicants' => $this->jobapply->groupBy('talent_id')->count(),
            'recent_applicants' => $this->jobapply->where('created_at', '>=', $sevenDaysAgo)->groupBy('talent_id')->count(),
            'status' => (string)$this->status,
            'date_created' => Carbon::parse($this->created_at)->format('j M Y'),
            'skills' => (array)$this->skills,
            'company' => (object) [
                'business_name' => (string)$this->business?->business_name,
                'about_company' => (string)$this->business?->about_business,
                'industry' => (string)$this->business?->industry,
                'logo' => (string)$this->business?->company_logo,
            ],
            'questions' => $this->questions->map(function($quest) {
                return [
                    "question" => $quest->question
                ];
            })->toArray()
        ];
    }
}
