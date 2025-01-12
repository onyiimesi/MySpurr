<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminExternalJobRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'company_name' => ['required', 'string'],
            'job_type' => ['required', 'in:remote,full-time,part-time,internship,contract'],
        ];
    }

    public function messages()
    {
        return [
            'job_type' => 'job type should be either remote, full-time, part-time, internship or contract'
        ];
    }
}
