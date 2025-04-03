<?php

namespace App\Http\Requests\Proposal;

use App\Enums\ProposalStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTenderProposalStatusRequest extends FormRequest
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
        $data = [
            ProposalStatus::UNDER_REVIEW->value,
            ProposalStatus::INITIAL_ACCEPTANCE->value,
            ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_REQUESTED->value,
            ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_SENT->value,
            ProposalStatus::WITHDRAWN->value,
            ProposalStatus::REJECTED->value,
            ProposalStatus::FINAL_ACCEPTANCE->value
        ];

        $statuses = implode(",", $data);

        // dd($statuses);

        return [
            "status" => [
                "required",
                "string",
                "in:" . $statuses,
            ],
        ];
    }
}
