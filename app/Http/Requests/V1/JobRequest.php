<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'job_title' => ['required'],
            'location' => ['required'],
            'skills' => ['required'],
            'rate' => ['required'],
            'commitment' => ['required'],
            'job_type' => ['required'],
            'capacity' => ['required'],
        ];
    }
}
