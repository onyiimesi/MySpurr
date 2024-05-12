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
            'country_code' => (string)$this->country_code,
            'phone_number' => (string)$this->phone_number,
            'skill_title' => (string)$this->skill_title,
            'overview' => (string)$this->overview,
            'ciso' => (string)$this->ciso,
            'siso' => (string)$this->siso,
            'location' => (string)$this->location,
            'longitude' => (string)$this->longitude,
            'latitude' => (string)$this->latitude,
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
                    'id' => $edu->id,
                    'school_name' => $edu->school_name,
                    'degree' => $edu->degree,
                    'field_of_study' => $edu->field_of_study,
                    'start_date' => Carbon::parse($edu->start_date)->format('j M Y'),
                    'end_date' => Carbon::parse($edu->end_date)->format('j M Y'),
                    'description' => $edu->description
                ];
            })->toArray(),
            'employment' => $this->employments->map(function($emp) {
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
            'certificate' => $this->certificates->map(function($cert) {
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
            'portfolio' => $this->portfolios->map(function($port) {
                return [
                    'id' => $port->id,
                    'title' => $port->title,
                    'category_id' => $port->category_id,
                    'description' => $port->description,
                    'project_image' => $port->portfolioprojectimage->map(function ($data) {
                        return [
                            'id' => $data->id,
                            'image' => $data->image
                        ];
                    })->toArray(),
                    'tags' => json_decode($port->tags),
                    'link' => $port->link,
                    'featured_image' =>  $port->featured_image,
                    'is_draft' =>  $port->is_draft,
                ];
            })->toArray(),
            'wallet' => (object) [
                'wallet_no' => $this->talentwallet?->wallet_no
            ],
            'billing_address' => (object) [
                'country' => $this->talentbillingaddress?->country,
                'state' => $this->talentbillingaddress?->state,
                'address_1' => $this->talentbillingaddress?->address_1,
                'address_2' => $this->talentbillingaddress?->address_2,
                'city' => $this->talentbillingaddress?->city,
                'zip_code' => $this->talentbillingaddress?->zip_code
            ],
            'identity' => (object) [
                'status' => $this->talentidentity?->status
            ],
            'experience_level' => (string)$this->experience_level,
            'booking_link' => (string)$this->booking_link,
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
