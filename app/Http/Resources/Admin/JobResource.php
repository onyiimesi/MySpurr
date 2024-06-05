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
            'title' => (string)$this->job_title,
            'business' => (string)$this->business->business_name,
            'location' => (string)$country->name. ' ' . $state->name,
            'budget' => (string)$this->salary_min . ' ' . '- ' . $this->salary_max,
            'applications' => $this->jobapply->groupBy(['talent_id'])->count(),
            'status' => (string)$this->status
        ];
    }
}
