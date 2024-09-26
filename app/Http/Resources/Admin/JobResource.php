<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
        $state = $states->where('country_id', $country->id)
        ->where('iso2', $this->state_id)->first();

        return [
            'title' => (string)$this->job_title,
            'business' => (string)$this->business->business_name,
            'location' => (string)$country->name. ' ' . $state->name,
            'budget' => (string)$this->salary_min . ' ' . '- ' . $this->salary_max,
            'applications' => $this->jobapply->groupBy(['talent_id'])->count(),
            'status' => (string)$this->status
        ];
    }
}
