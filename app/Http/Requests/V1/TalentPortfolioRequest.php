<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class TalentPortfolioRequest extends FormRequest
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
            'portfolio.title' => ['required', 'string'],
            'portfolio.client_name' => ['required', 'string'],
            'portfolio.job_type' => ['required', 'string'],
            'portfolio.location' => ['required', 'string'],
            'portfolio.rate' => ['required', 'string'],
            'portfolio.cover_image' => ['required'],
            'portfolio.body' => ['required']
        ];
    }
}
