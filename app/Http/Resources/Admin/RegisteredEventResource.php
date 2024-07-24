<?php

namespace App\Http\Resources\Admin;

use App\Models\V1\RegisteredEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RegisteredEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'creative_profession' => (string)$this->creative_profession,
            'email' => (string)$this->email,
            'phone_number' => (string)$this->phone_number,
            'description' => (string)$this->description
        ];
    }
}
