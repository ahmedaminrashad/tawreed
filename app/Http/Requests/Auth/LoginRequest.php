<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest\ApiFormRequest;

class LoginRequest extends ApiFormRequest
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
            'login_text' => ['required', 'string'],
            'login_password'  => ['required', 'min:8'],
        ];

        return $validations;
    }

    public function attributes(): array
    {
        return [
            'login_text' => 'Email or Commercial Registration Number',
            'login_password' => 'Password',
        ];
    }
}
