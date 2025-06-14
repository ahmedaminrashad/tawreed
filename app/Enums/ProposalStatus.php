<?php

namespace App\Enums;

use App\Enums\EnumToArray;

enum ProposalStatus: string
{
    use EnumToArray;

    case DRAFT = 'draft';
    case CREATED = 'created';
    case UNDER_REVIEW = 'under review';
    case INITIAL_ACCEPTANCE = 'initial acceptance';
    case INITIAL_ACCEPTANCE_SAMPLE_REQUESTED = 'initial acceptance (sample requested)';
    case INITIAL_ACCEPTANCE_SAMPLE_SENT = 'initial acceptance (sample sent)';
    case WITHDRAWN = 'withdrawn';
    case REJECTED = 'rejected';
    case FINAL_ACCEPTANCE = 'final acceptance';

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => __('web.draft_proposal'),
            self::CREATED => __('web.created_proposal'),
            self::UNDER_REVIEW => __('web.under_review_proposal'),
            self::INITIAL_ACCEPTANCE => __('web.initial_acceptance_proposal'),
            self::INITIAL_ACCEPTANCE_SAMPLE_REQUESTED => __('web.initial_acceptance_sample_requested_proposal'),
            self::INITIAL_ACCEPTANCE_SAMPLE_SENT => __('web.initial_acceptance_sample_sent_proposal'),
            self::WITHDRAWN => __('web.withdrawn_proposal'),
            self::REJECTED => __('web.rejected_proposal'),
            self::FINAL_ACCEPTANCE => __('web.final_acceptance_proposal'),
        };
    }
}
