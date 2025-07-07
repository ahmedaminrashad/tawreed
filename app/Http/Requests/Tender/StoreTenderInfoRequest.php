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
            "contract_duration" => ["required", "numeric", "min:1", 'regex:/^[0-9]+$/'],
            "contract_start_date" => ["required", "date", 'after:today', "date_format:m/d/Y"],
            "contract_end_date" => ["required", "date", 'after:contract_start_date', "date_format:m/d/Y"],
            "closing_date" => ["required", "date", 'before:contract_start_date',"after:today", "date_format:m/d/Y"],
            "proposal_evaluation_duration" => ["required", "numeric", "min:1"],
            "address" => ["required", "string", "max:3000"],
            "latitude" =>  ["required", "numeric", "min:-90", "max:90"],
            "longitude" =>  ["required", "numeric", "min:-180", "max:180"],
        ];
    }

    public function attributes(): array
    {
        return [
            "country_id" => __("admin.country"),
            "city_id" => __("admin.city"),
            "category_id" => __("admin.category"),
            "activity_id" => __("admin.activity"),
            "desc" => __("web.description"),
            "latitude" => __("web.location"),
            "longitude" => __("web.location"),
            "closing_date" => __("admin.closing_date"),
            "contract_start_date" => __("admin.contract_start_date"),
            "contract_end_date" => __("admin.contract_end_date"),
        
        ];
    }
    public function messages(): array
    {
        return [
            "closing_date.before" => __("admin.closing_date_before"),
            "closing_date.after" => __("admin.closing_date_after"),
            "contract_start_date.after" => __("admin.contract_start_date_after"),
            "contract_end_date.after" => __("admin.contract_end_date_after"),
            "contract_start_date.date_format" => __("admin.contract_start_date_date_format"),
            "contract_end_date.date_format" => __("admin.contract_end_date_date_format"),
            "closing_date.date_format" => __("admin.closing_date_date_format"),
            "contract_start_date.date" => __("admin.contract_start_date_date"),
            "contract_end_date.date" => __("admin.contract_end_date_date"),
            "closing_date.date" => __("admin.closing_date_date"),
            "contract_start_date.required" => __("admin.contract_start_date_required"),
            "contract_end_date.required" => __("admin.contract_end_date_required"),
            "closing_date.required" => __("admin.closing_date_required"),
        ];
    }

    protected function prepareForValidation()
    {
        if (isset($this->contract_duration)) {
            $this->merge([
                'contract_duration' => $this->convertArabicToEnglishNumbers($this->contract_duration)
            ]);
        }
    }

    private function convertArabicToEnglishNumbers($number)
    {
        $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($arabic, $english, $number);
    }
}
