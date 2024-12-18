<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use App\Models\V1\TalentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminJobResource extends JsonResource
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
        $state = $states->where('country_id', $country?->id)
                        ->where('iso2', $this->state_id)->first();

        $jobsByStatus = TalentJob::where('business_id', $this?->business->id)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return [
            'id' => (string)$this->id,
            'job_title' => (string)$this->job_title,
            'slug' => (string)$this->slug,
            'country' => (string)$country?->name,
            'state' => (string)$state?->name,
            'country_id' => (string)$country?->iso2,
            'state_id' => (string)$state?->iso2,
            'job_type' => (string)$this->job_type,
            'description' => (string)$this->description,
            'responsibilities' => (string)$this->responsibilities,
            'required_skills' => (string)$this->required_skills,
            'skills' => $this->skills,
            'benefits' => (string)$this->benefits,
            'salaray_type' => (string)$this->salaray_type,
            'salary_min' => (string)$this->salary_min,
            'salary_max' => (string)$this->salary_max,
            'currency' => (string)$this->currency,
            'experience' => (string)$this->experience,
            'qualification' => (string)$this->qualification,
            'applicants' => $this->jobapply->groupBy(['talent_id'])->count(),
            'is_bookmark' => (string)$this->is_bookmark,
            'is_highlighted' => (string)$this->is_highlighted,
            'status' => (string)$this->status,
            'date_created' => Carbon::parse($this->created_at)->format('j M Y'),
            'questions' => $this->questions->map(fn($quest) => ['question' => $quest->question]),
            'business_id' => $this->business?->id,
            'business_name' => $this->business?->business_name,
            'company' => [
                'business_name' => $this->business?->business_name,
                'industry' => (array)$this->business?->industry,
                'about_business' => $this->business?->about_business,
                'company_logo' => $this->business?->company_logo,
            ],
            'total_opened_jobs' => $jobsByStatus->get('active')?->count ?? 0,
            'completed_jobs' => $jobsByStatus->get('completed')?->count ?? 0,
            'hired_jobs' => $jobsByStatus->get('hired')?->count ?? 0,
        ];
    }
}
