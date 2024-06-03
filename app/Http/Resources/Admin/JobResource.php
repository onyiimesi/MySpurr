<?php

namespace App\Http\Resources\Admin;

use App\Models\V1\TalentJob;
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

        return [
            'id' => (string)$this->id,
            'title' => (string)$this->job_title,
            'business' => (string)$this->business->business_name,
            'slug' => (string)$this->slug,
            'country' => (string)$country->name,
            'state' => (string)$state->name,
            'salaray_type' => (string)$this->salaray_type,
            'salary_min' => (string)$this->salary_min,
            'salary_max' => (string)$this->salary_max,
            'applicants' => $this->jobapply->groupBy(['talent_id'])->count(),
            'status' => (string)$this->status,
            'date_created' => Carbon::parse($this->created_at)->format('j M Y')
        ];
    }
}
