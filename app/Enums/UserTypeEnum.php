<?php

namespace App\Enums;

enum UserTypeEnum: int
{
    use EnumToArray;

    case STUDENT = 0;
    case FATHER = 1;
    case MOTHER = 2;

    public function label() {
        return match($this) {
            self::STUDENT => 'Student',
            self::FATHER => 'Father',
            self::MOTHER => 'Mother',
        };
    }
}
