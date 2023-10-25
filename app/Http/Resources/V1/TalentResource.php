<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentResource extends JsonResource
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
            'uniqueId' => (string)$this->uuid,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'email' => (string)$this->email,
            'skill_title' => (string)$this->skill_title,
            'overview' => (string)$this->overview,
            'location' => (string)$this->location,
            'employment_type' => (string)$this->employment_type,
            'highest_education' => (string)$this->highest_education,
            'rate' => (string)$this->rate,
            'top_skills' => $this->topskills->map(function($skill) {
                return [
                    'name' => $skill->name
                ];
            })->toArray(),
            'education' => $this->educations->map(function($edu) {
                return [
                    'school_name' => $edu->school_name,
                    'degree' => $edu->degree,
                    'field_of_study' => $edu->field_of_study,
                    'start_date' => Carbon::createFromFormat('d/m/Y', $edu->start_date)->format('j M Y'),
                    'end_date' => Carbon::createFromFormat('d/m/Y', $edu->end_date)->format('j M Y'),
                    'description' => $edu->description
                ];
            })->toArray(),
            'employment' => $this->employments->map(function($emp) {
                return [
                    'company_name' => $emp->company_name,
                    'title' => $emp->title,
                    'employment_type' => $emp->employment_type,
                    'start_date' => Carbon::createFromFormat('d/m/Y', $emp->start_date)->format('j M Y'),
                    'end_date' => Carbon::createFromFormat('d/m/Y', $emp->end_date)->format('j M Y'),
                    'description' => $emp->description
                ];
            })->toArray(),
            'certificate' => $this->certificates->map(function($cert) {
                return [
                    'title' => $cert->title,
                    'institute' => $cert->institute,
                    'certificate_date' => Carbon::createFromFormat('d/m/Y', $cert->certificate_date)->format('j M Y'),
                    'certificate_year' => $cert->certificate_year,
                    'certificate_link' => $cert->certificate_link,
                    'curently_working_here' => $cert->curently_working_here
                ];
            })->toArray(),
            'portfolio' => $this->portfolios->map(function($port) {
                return [
                    'title' => $port->title,
                    'client_name' => $port->client_name,
                    'job_type' => $port->job_type,
                    'location' => $port->location,
                    'rate' => $port->rate,
                    'tags' => json_decode($port->tags),
                    'cover_image' => $port->cover_image,
                    'body' =>  $port->body
                ];
            })->toArray(),
            'compensation' => (string)$this->compensation,
            'image' => (string)$this->image,
            'linkedin' => (string)$this->linkedin,
            'instagram' => (string)$this->instagram,
            'twitter' => (string)$this->twitter,
            'behance' => (string)$this->behance,
            'facebook' => (string)$this->facebook,
            'availability' => (string)$this->availability,
            'type' => (string)$this->type,
            'status' => (string)$this->status
        ];
    }
}
