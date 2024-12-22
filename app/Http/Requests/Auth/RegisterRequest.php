<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserType;
use App\Http\Requests\FormRequest\ApiFormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends ApiFormRequest
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
        $base = [
            'account_type' => ['required', 'string', Rule::enum(UserType::class)],
        ];

        if ($this->request->all()['account_type'] == 'individual') {
            $additional = [
                'full_name' => ['required', 'string', 'max:255'],
                'individual_password'  => ['required', 'min:8', 'confirmed'],
                'read_individual'  => ['required', 'min:1', 'max:1'],
                'country_id_individual' => ['required', 'numeric', 'exists:countries,id'],
                'email_individual' => ['required', 'email', 'unique:users,email'],
            ];
        } else if ($this->request->all()['account_type'] == 'company') {
            $additional = [
                'company_name' => ['required', 'string', 'max:255'],
                'crn' => ['required', 'string', 'max:255', 'unique:users,commercial_registration_number'],
                'company_password'  => ['required', 'min:8', 'confirmed'],
                'read_company'  => ['required', 'min:1', 'max:1'],
                'country_id_company' => ['required', 'numeric', 'exists:countries,id'],
                'email_company' => ['required', 'email', 'unique:users,email'],
            ];
        }

        $validations = array_merge($base, $additional);

        return $validations;
    }

    public function attributes(): array
    {
        return [
            // individual
            'email_individual' => 'Email',
            'country_id_individual' => 'Country',
            'individual_password' => 'Password',
            'individual_password_confirmation' => 'Password Confirmation',
            'read_individual' => 'Read Terms & Conditions and Privacy Policy',

            // Company
            'crn' => 'Commercial Registration Number',
            'email_company' => 'Email',
            'country_id_company' => 'Country',
            'company_password' => 'Password',
            'company_password_confirmation' => 'Password Confirmation',
            'read_company' => 'Read Terms & Conditions and Privacy Policy'
        ];
    }
}
