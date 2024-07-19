<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisteredEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'creative_profession' => ['required', 'string'],
            'email' => ['required', 'email', 'email:rfc,dns'],
            'phone_number' => ['required', 'string'],
        ];
    }
}
