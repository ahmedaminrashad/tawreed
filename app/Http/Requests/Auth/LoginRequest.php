<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest\ApiFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'login_text' => ['required', 'string'],
            'login_password'  => ['required', 'min:8'],
        ];
    }



    public function attributes(): array
    {
        return [
            'login_text' => 'Email or Commercial Registration Number',
            'login_password' => 'Password',
        ];
    }
}
