<?php

namespace App\Enums;

enum EducationSystemEnum: int
{
    use EnumToArray;

    // case THANEWYA_AMMA = 'Thanewya Amma';
    // case IB = 'IB';
    // case IGCSE = 'IGCSE';
    // case AMERICAN_DIPLOMA = 'American Diploma';
    // case FRENCH_BACCALAUREATE = 'French Baccalaureate';
    // case ABITUR = 'Abitur';
    // case NILE = 'Nile';
    // case CANADIAN_DIPLOMA = 'Canadian Diploma';
    // case STEM = 'STEM';
    // case OTHERS = 'Others';

    case THANEWYA_AMMA = 0;
    case IB = 1;
    case IGCSE = 2;
    case AMERICAN_DIPLOMA = 3;
    case FRENCH_BACCALAUREATE = 4;
    case ABITUR = 5;
    case NILE = 6;
    case CANADIAN_DIPLOMA = 7;
    case STEM = 8;
    case OTHERS = 9;

    public function label()
    {
        return match ($this) {
            self::THANEWYA_AMMA => 'THANEWYA_AMMA',
            self::IB => 'IB',
            self::IGCSE => 'IGCSE',
            self::AMERICAN_DIPLOMA => 'AMERICAN_DIPLOMA',
            self::FRENCH_BACCALAUREATE => 'FRENCH_BACCALAUREATE',
            self::ABITUR => 'ABITUR',
            self::NILE => 'NILE',
            self::CANADIAN_DIPLOMA => 'CANADIAN_DIPLOMA',
            self::STEM => 'STEM',
            self::OTHERS => 'OTHERS',
        };
    }
}
