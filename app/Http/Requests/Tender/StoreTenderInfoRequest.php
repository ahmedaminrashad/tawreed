<?php

namespace App\Http\Requests\Tender;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenderInfoRequest extends FormRequest
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
            "subject" => ["required", "string", "max:255"],
            "project" =>  ["nullable", "string", "max:255"],
            "country_id" => ["required", "numeric", "exists:countries,id"],
            "city_id" => ["required", "numeric", "exists:cities,id"],
            "category_id" =>  ["required", "numeric", "exists:classifications,id"],
            "activity_id" => ["required", "numeric", "exists:activity_classifications,id"],
            "desc" => ["nullable", "string", "max:3000"],
            "contract_duration" => ["required", "numeric", "min:1"],
            "contract_start_date" => ["required", "date", "date_format:m/d/Y"],
            "contract_end_date" => ["required", "date", "date_format:m/d/Y"],
            "closing_date" => ["required", "date", "date_format:m/d/Y"],
            "proposal_evaluation_duration" => ["required", "numeric", "min:1"],
            "address" => ["required", "string", "max:3000"],
            "latitude" =>  ["required", "numeric", "min:-90", "max:90"],
            "longitude" =>  ["required", "numeric", "min:-180", "max:180"],
        ];
    }

    public function attributes(): array
    {
        return [
            "country_id" => "Country",
            "city_id" => "City",
            "category_id" => "Category Work Classification",
            "activity_id" => "Activity Classification",
            "desc" => "Description",
            "latitude" => "Location",
            "longitude" => "Location",
        ];
    }
}
