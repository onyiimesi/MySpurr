<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class JobApplyRequest extends FormRequest
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
            'job_id' => ['required'],
            'rate' => ['required'],
            'available_start' => ['required'],
            'resume' => 'required',
            'question_answers' => 'required|array|min:1',
            'question_answers.*.answer' => 'required|string',
        ];
    }
}
