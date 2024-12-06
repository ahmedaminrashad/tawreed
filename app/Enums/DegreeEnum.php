<?php

namespace App\Enums;

enum DegreeEnum: int
{
    use EnumToArray;

    case BACHELOR = 0;
    case MASTER = 1;

    public function label()
    {
        return match ($this) {
            self::BACHELOR => 'Bachelor',
            self::MASTER => 'Master'
        };
    }
}
