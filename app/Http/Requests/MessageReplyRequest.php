<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageReplyRequest extends FormRequest
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
            'message_id' => ['required', 'integer', 'exists:messages,id'],
            'sender_id' => ['required', 'integer'],
            'receiver_email' => ['required', 'email', 'email:rfc,dns'],
            'receiver_id' => ['required', 'integer'],
            'message' => ['required', 'string'],
        ];
    }
}
