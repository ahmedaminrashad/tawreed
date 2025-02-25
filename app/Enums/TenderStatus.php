<?php

namespace App\Enums;

use App\Enums\EnumToArray;

enum TenderStatus: string
{
    use EnumToArray;

    case DRAFT = 'draft';
    case CREATED = 'created';
    // case PUBLISHED = 'published';
    case IN_PROGRESS = 'in progress';
    case AWARDED = 'awarded';
    case CANCELLED = 'Cancelled';
    case AUTOMATIC_CANCELLED = 'automatically canceled';
}
