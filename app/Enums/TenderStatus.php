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

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => __('web.draft_tender'),
            self::CREATED => __('web.created_tender'),
            self::IN_PROGRESS => __('web.in_progress_tender'),
            self::AWARDED => __('web.awarded_tender'),
            self::CANCELLED => __('web.cancelled_tender'),
            self::AUTOMATIC_CANCELLED => __('web.automatically_cancelled_tender'),
        };
    }

}