<?php

namespace App\Http\Requests\Proposal;

use Illuminate\Foundation\Http\FormRequest;

class RejectProposalRequest extends FormRequest
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
            "custom_reject_reason" => ["required_if:reject_reason,==,4", "max:2000"],
            "reject_reason" => ["required"],
        ];
    }
}
