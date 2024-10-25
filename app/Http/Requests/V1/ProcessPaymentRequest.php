<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProcessPaymentRequest extends FormRequest
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
            'business_id' => 'required|numeric',
            'email' => 'required|email|string',
            'payment_redirect_url' => 'required',
            'job' => 'required',
            'type' => 'required|in:premium',
            'payment_option' => 'required|in:online,invoice'
        ];
    }

    public function messages()
    {
        return [
            'payment_option' => 'The selected payment option should either be online or invoice.'
        ];
    }
}
