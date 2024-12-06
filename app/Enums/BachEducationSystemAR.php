<?php

namespace App\Enums;

use App\Enums\EnumToArray;

enum BachEducationSystemAR: string
{
    case THANEWYA_AMMA = 'الثانوية العامة';
    case IB = 'البكالوريا الدولية';
    case IGCSE = ' الشهادة الدولية العامة للتعليم الثانوي';
    case AMERICAN_DIPLOMA = 'الدبلومة الأمريكية';
    case FRENCH_BACCALAUREATE = 'الباكالوريا الفرنسية';
    case ABITUR = 'شهادة الدراسة الثانوية';
    case NILE = 'نايل';
    case CANADIAN_DIPLOMA = 'الدبلومة الكندية';
    case STEM = 'العلوم والتكنولوجيا والهندسة والرياضيات';
    case OTHERS = 'آخرى';
}
