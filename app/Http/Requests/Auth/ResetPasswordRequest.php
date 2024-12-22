<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest\ApiFormRequest;

class ResetPasswordRequest extends ApiFormRequest
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
            'otp_user' => ['required', 'numeric', 'exists:users,id'],
            'otp'  => ['required', 'numeric', 'digits:6'],
            'new_password'  => ['required', 'min:8', 'confirmed'],
        ];

        return $validations;
    }

    public function attributes(): array
    {
        return [
            'otp_user' => 'User',
            'otp' => 'OTP',
            'new_password' => 'Password',
        ];
    }
}
