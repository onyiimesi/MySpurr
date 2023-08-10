<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessPortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'company_logo' => (string)$this->company_logo,
            'company_type' => (string)$this->company_type,
            'social_media' => (string)$this->social_media,
            'social_media_two' => (string)$this->social_media_two
        ];
    }
}
