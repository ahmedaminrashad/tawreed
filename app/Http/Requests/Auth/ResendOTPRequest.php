<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest\ApiFormRequest;

class ResendOTPRequest extends ApiFormRequest
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
        $validations = [
            'resend_otp_user' => ['required', 'numeric', 'exists:users,id'],
        ];

        return $validations;
    }

    public function attributes(): array
    {
        return [
            'resend_otp_user' => 'User',
        ];
    }
}
