<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
            "country_id" => ['required', 'numeric', 'exists:countries,id'],
        ];

        foreach (config('langs') as $locale => $name) {
            $validationRules[$locale . "_name"] = ['required', 'string', 'max:255'];
        }

        return $validationRules;
    }
}
