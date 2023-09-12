<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => (string)$this->id,
            // 'first_name' => (string)$this->first_name,
            // 'last_name' => (string)$this->last_name,
            // 'email_address' => (string)$this->email_address,
            'type' => (string)$this->type,
            'status' => (string)$this->status,
        ];
    }
}
