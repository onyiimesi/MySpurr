<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class BusinessDetailsRequest extends FormRequest
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
            'business_name' => ['required', 'string'],
            'industry' => ['required', 'string'],
            'about_business' => ['required', 'string'],
            'business_service' => ['required', 'string'],
            'business_email' => ['required', 'email', 'email:rfc,dns', 'string']
        ];
    }
}
