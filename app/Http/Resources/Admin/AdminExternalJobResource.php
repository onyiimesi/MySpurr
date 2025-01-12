<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminExternalJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'title' => (string)$this->title,
            'slug' => (string)$this->slug,
            'company_name' => (string)$this->company_name,
            'location' => (string)$this->location,
            'job_type' => (string)$this->job_type,
            // 'description' => (string)$this->description,
            // 'responsibilities' => (string)$this->responsibilities,
            // 'required_skills' => (string)$this->required_skills,
            'salary_min' => (string)$this->salary_min,
            'salary_max' => (string)$this->salary_max,
            'salary_type' => (string)$this->salary_type,
            'currency' => (string)$this->currency,
            'link' => (string)$this->link,
            'status' => (string)$this->status,
            'date_created' => Carbon::parse($this->created_at)->format('j M Y')
        ];
    }
}
