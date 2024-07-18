<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:200'],
            'speaker_bio' => ['required', 'string'],
            'speaker' => ['required', 'string', 'max:200'],
            'speaker_title' => ['required', 'string', 'max:200'],
            'event_time' => ['required', 'string', 'max:200'],
            'event_date' => ['required', 'date'],
            'timezone' => ['required', 'string', 'max:200'],
            'address' => ['required', 'string', 'max:200'],
            'linkedln' => ['required', 'string', 'max:200'],
            'content' => ['required'],
            'featured_speaker' => ['required'],
            'featured_graphics' => ['required']
        ];
    }
}
