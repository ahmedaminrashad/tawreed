<?php

namespace App\Http\Requests\Proposal;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenderProposalInfoRequest extends FormRequest
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
            "proposal_end_date" => ["required", "date", 'after:today', "date_format:m/d/Y"],
            "contract_duration" => ["required", "numeric", "min:1"],
            "payment_terms" => ["nullable", "string", "max:3000"],
            "proposal_desc" => ["nullable", "string", "max:3000"],
            "allow_announcement" => ["nullable", "numeric", "max:1"],
        ];
    }

    public function attributes(): array
    {
        return [
            "proposal_desc" => __("web.proposal_desc"),
            "proposal_end_date" => __("web.proposal_end_date"),
        ];
    }
    public function messages(): array
    {
        return [
            "proposal_end_date.after" => __("web.proposal_end_date_after"),

        ];
    }
}
