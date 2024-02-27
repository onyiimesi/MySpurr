<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'business_name' => (string)$this->business_name,
            'location' => (string)$this->location,
            'longitude' => (string)$this->longitude,
            'latitude' => (string)$this->latitude,
            'industry' => (array)$this->industry,
            'about_business' => (string)$this->about_business,
            'website' => (string)$this->website,
            'business_service' => (string)$this->business_service,
            'business_email' => (string)$this->business_email,
            'company_logo' => (string)$this->company_logo,
            'company_type' => (string)$this->company_type,
            'social_media' => (string)$this->social_media,
            'social_media_two' => (string)$this->social_media_two,
            'type' => (string)$this->type,
            'status' => (string)$this->status
        ];
    }
}
