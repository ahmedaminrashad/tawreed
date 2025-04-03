<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            // "image" => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:10240'],
            "country_code" => ["nullable", "numeric", "exists:countries,id"],
            "phone" => ["nullable", "string", "max:255"],
            "country_id" => ["required", "numeric", "exists:countries,id"],
            "category_id" =>  ["nullable", "array"],
            "category_id.*" =>  ["numeric", "exists:classifications,id"],
            "address" => ["nullable", "string", "max:2000"],
            "latitude" =>  ["nullable", "numeric", "min:-90", "max:90"],
            "longitude" =>  ["nullable", "numeric", "min:-180", "max:180"],
        ];

        if (auth()->user()->isCompany()) {
            $validationRules["company_name"] = ["required", "string", "max:255"];
            $validationRules["commercial_registration_number"] = ["required", "integer", "digits:10"];
            $validationRules["tax_card_number"] = ["required", "integer", "digits:15"];
        } else {
            $validationRules["full_name"] = ["required", "string", "max:255"];
        }

        return $validationRules;
    }

    public function attributes(): array
    {
        return [
            "country_code" => "Country Code",
            "country_id" => "Country",
            "commercial_registration_number" => "Commercial Registration Number",
            "tax_card_number" => "Tax Card Number / Zakat Certificate",
            "category_id" => "Category Work Classification",
            "latitude" => "Location",
            "longitude" => "Location",
        ];
    }
}
