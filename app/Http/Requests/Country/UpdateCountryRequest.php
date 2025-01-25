<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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
        $validationRules = [
            "country_code" => ['required', 'string', 'max:255'],
            "vat" => ['required', 'numeric', 'min:0'],
        ];

        foreach (config('langs') as $locale => $name) {
            $validationRules[$locale . "_name"] = ['required', 'string', 'max:255'];
        }

        return $validationRules;
    }
}
