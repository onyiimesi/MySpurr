<?php

namespace App\Http\Resources\V1;

use App\Models\V1\JobApply;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TalentJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $countries = get_countries();
        $states = get_states();

        $country = $countries->where('iso2', $this->country_id)->first();
        $state = null;

        if ($country) {
            $state = $states->where('country_id', $country->id)
                ->where('iso2', $this->state_id)->first();
        }

        $currentDateTime = Carbon::now();
        $sevenDaysAgo = $currentDateTime->subDays(7);

        $user = Auth::user();

        $status = null;
        if ($user) {
            foreach ($this->jobapply as $apply) {
                $talentapply = JobApply::where('job_id', $apply->job_id)
                    ->where('talent_id', $user->id)
                    ->first();

                if ($talentapply) {
                    $status = "applied";
                    break;
                }
            }
        }

        return [
            'id' => (string)$this->id,
            'country' => (string)($country?->name ?? 'Unknown'),
            'state' => (string)($state?->name ?? 'Unknown'),
            'job_title' => (string)$this->job_title,
            'slug' => (string)$this->slug,
            'job_type' => (string)$this->job_type,
            'experience' => (string)$this->experience,
            'description' => (string)$this->description,
            'salaray_type' => (string)$this->salaray_type,
            'salary_min' => (string)$this->salary_min,
            'salary_max' => (string)$this->salary_max,
            'currency' => (string)$this->currency,
            'applicants' => $this->jobapply->groupBy('talent_id')->count(),
            'recent_applicants' => $this->jobapply->where('created_at', '>=', $sevenDaysAgo)->groupBy('talent_id')->count(),
            'application_status' => $status,
            'is_bookmark' => (string)$this->is_bookmark,
            'is_highlighted' => (string)$this->is_highlighted,
            'status' => (string)$this->status,
            'date_created' => Carbon::parse($this->created_at)->format('j M Y'),
            'skills' => (array)$this->skills,
            'company' => (object) [
                'business_name' => (string)$this->business?->business_name,
                'about_company' => (string)$this->business?->about_business,
                'industry' => (array)$this->business?->industry,
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

