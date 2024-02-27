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
            'applicants' => $this->jobapply->map(function ($applicant) {
                return [
                    'id' => $applicant->id,
                    'talent_id' => $applicant->talent_id,
                    'first_name' => $applicant->talent->first_name,
                    'last_name' => $applicant->talent->last_name,
                    'email' => $applicant->talent->email,
                    'phone_number' => $applicant->talent->phone_number,
                    'image' => $applicant->talent->image,
                    'top_skills' => $applicant->talent->topskills->map(function($skill) {
                        return [
                            'name' => $skill->name
                        ];
                    })->toArray(),
                    'education' => $applicant->talent->educations->map(function($edu) {
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
                            'curently_working_here' => $cert->curently_working_here
                        ];
                    })->toArray(),
                    'portfolio' => $applicant->talent->portfolios->map(function($port) {
                        return [
                            'id' => $port->id,
                            'title' => $port->title,
                            'client_name' => $port->client_name,
                            'job_type' => $port->job_type,
                            'location' => $port->location,
                            'max_rate' => $port->max_rate,
                            'min_rate' => $port->min_rate,
                            'tags' => json_decode($port->tags),
                            'cover_image' => $port->cover_image,
                            'body' =>  $port->body,
                            'is_draft' =>  $port->is_draft,
                        ];
                    })->toArray()
                ];
            })->toArray()
        ];
    }
}
