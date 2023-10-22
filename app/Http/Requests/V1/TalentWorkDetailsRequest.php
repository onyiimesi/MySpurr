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
            'availability' => ['required', 'string'],
            'education.school_name' => ['required'],
            'education.degree' => ['required'],
            'education.description' => ['required'],
            'education.start_date' => ['required'],
            'employment_details.company_name' => ['required'],
            'employment_details.title' => ['required'],
            'employment_details.employment_type' => ['required'],
            'employment_details.start_date' => ['required'],
            'certificate.title' => ['required'],
            'certificate.institute' => ['required'],
            'certificate.certificate_date' => ['required'],
            'certificate.certificate_year' => ['required']
        ];
    }
}
