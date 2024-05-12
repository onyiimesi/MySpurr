<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreTalentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string',],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'email:rfc,dns', 'string', 'max:255', 'unique:talent'],
            'password' => ['string', Rules\Password::defaults()],
            'country_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'numeric'],
            'status' => ['string', 'max:20']
        ];
    }
}
