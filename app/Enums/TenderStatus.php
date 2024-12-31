<?php

namespace App\Enums;

use App\Enums\EnumToArray;

enum TenderStatus: string
{
    use EnumToArray;

    case DRAFT = 'draft';
    case CREATED = 'created';
    case PUBLISHED = 'published';
}
