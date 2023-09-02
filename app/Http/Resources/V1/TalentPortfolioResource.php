<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentPortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'compensation' => (string)$this->compensation,
            'portfolio_title' => (string)$this->portfolio_title,
            'portfolio_description' => (string)$this->portfolio_description,
            'image' => (string)$this->image,
            'social_media_link' => (string)$this->social_media_link,
        ];
    }
}
