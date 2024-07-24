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
            'country_id' => ['required'],
            'state_id' => ['required'],
            'job_type' => ['required', 'in:remote,full-time,part-time,internship,contract'],
            'description' => ['required'],
            'responsibilities' => ['required'],
            'required_skills' => ['required'],
            'salaray_type' => ['required'],
            'salary_min' => ['required'],
            'salary_max' => ['required'],
            'currency' => ['required'],
            'skills' => ['required'],
            'experience' => ['required'],
            'qualification' => ['required'],
            'questions.*' => ['required', 'array'],
            'questions.*.question' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'job_type' => 'job type should be either remote, full-time, part-time, internship or contract',
            'questions.*.question' => 'Question field is required'
        ];
    }
}
