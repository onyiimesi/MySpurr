<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
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
            'attribute' => [
                'name' => (string)$this->name,
                'email' => (string)$this->email,
                'subject' => (string)$this->subject,
                'message' => (string)$this->message
            ]
        ];
    }
}
