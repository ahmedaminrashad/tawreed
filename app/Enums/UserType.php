<?php

namespace App\Enums;

use App\Enums\EnumToArray;

enum UserType: string
{
    use EnumToArray;

    case INDIVIDUAL = 'individual';
    case COMPANY = 'company';
}
