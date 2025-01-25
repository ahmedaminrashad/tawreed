<?php

namespace App\Http\Requests\Profile\Notification;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileNotificationsRequest extends FormRequest
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
            "push_notify" => ['required', 'numeric', 'min:0', 'max:1'],
            "email_notify" => ['required', 'numeric', 'min:0', 'max:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            "push_notify" => "Push Notifications",
            "email_notify" => "Email Notifications",
        ];
    }
}
