<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminJobRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'job_type' => 'job type should be either remote, full-time, part-time, internship or contract'
        ];
    }
}
