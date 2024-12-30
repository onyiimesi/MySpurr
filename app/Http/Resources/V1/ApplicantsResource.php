<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ApplicantsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job_title' => $this->job_title,
            'slug' => $this->slug,
            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'applicants' => $this->jobapply ? $this->jobapply->map(function ($applicant) {
                return [
                    'id' => $applicant?->id,
                    'talent_id' => $applicant?->talent_id,
                    'first_name' => $applicant?->talent?->first_name,
                    'last_name' => $applicant?->talent?->last_name,
                    'email' => $applicant?->talent?->email,
                    'phone_number' => $applicant?->talent?->phone_number,
                    'image' => $applicant?->talent?->image,
                    'location' => $applicant?->talent?->location,
                    'experience_level' => $applicant?->talent?->experience_level,
                    'availaibility' => $applicant?->talent?->availability,
                    'rate' => $applicant?->talent?->rate,
                    'rating' => $applicant?->talent?->ratingsReceived?->first()?->rating,
                    'top_skills' => $applicant?->talent?->topskills->map(function($skill) {
                        return [
                            'name' => $skill->name
                        ];
                    })->toArray(),
                    'education' => $applicant?->talent?->educations->map(function($edu) {
                        return [
                            'id' => $edu->id,
                            'school_name' => $edu->school_name,
                            'degree' => $edu->degree,
                            'field_of_study' => $edu->field_of_study,
                            'start_date' => Carbon::parse($edu->start_date)->format('j M Y'),
                            'end_date' => Carbon::parse($edu->end_date)->format('j M Y'),
                            'description' => $edu->description
                        ];
                    })->toArray(),
                    'employment' => $applicant->talent->employments->map(function($emp) {
                        return [
                            'id' => $emp->id,
                            'company_name' => $emp->company_name,
                            'title' => $emp->title,
                            'employment_type' => $emp->employment_type,
                            'start_date' => Carbon::parse($emp->start_date)->format('j M Y'),
                            'end_date' => Carbon::parse($emp->end_date)->format('j M Y'),
                            'description' => $emp->description
                        ];
                    })->toArray(),
                    'certificate' => $applicant->talent->certificates->map(function($cert) {
                        return [
                            'id' => $cert->id,
                            'title' => $cert->title,
                            'institute' => $cert->institute,
                            'certificate_date' => Carbon::parse($cert->certificate_date)->format('j M Y'),
                            'certificate_year' => $cert->certificate_year,
                            'certificate_link' => $cert->certificate_link,
                            'curently_working_here' => $cert->currently_working_here
                        ];
                    })->toArray(),
                    'portfolio' => $applicant->talent->portfolios->map(function($port) {
                        return [
                            'id' => $port->id,
                            'title' => $port->title,
                            'category_id' => $port->category_id,
                            'featured_image' => $port->featured_image,
                            'link' => $port->link,
                            'description' => $port->description,
                            'tags' => json_decode($port->tags),
                            'is_draft' =>  $port->is_draft,
                        ];
                    })->toArray()
                ];
            })->toArray() : [],
        ];
    }
}
