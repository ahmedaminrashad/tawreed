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
}
