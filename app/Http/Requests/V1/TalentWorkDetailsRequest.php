<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class TalentWorkDetailsRequest extends FormRequest
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
            'skill_title' => ['required', 'string'],
            'top_skills' => 'required|array|min:1',
            'top_skills.*.name' => 'required|string',
            'highest_education' => ['required', 'string'],
            'year_obtained' => ['required', 'string'],
            'work_history' => ['required', 'string'],
            'certificate_earned' => ['required', 'string'],
            'availability' => ['required', 'string']
        ];
    }
}
