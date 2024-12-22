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
            'forget_password_search' => ['required', 'string'],
        ];

        return $validations;
    }

    public function attributes(): array
    {
        return [
            'forget_password_search' => 'Email or Commercial Registration Number',
        ];
    }
}
