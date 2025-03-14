<?php

namespace App\Models;

use App\Enums\TenderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tender extends Model
{
    use HasFactory;

    public $table = 'tenders';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => TenderStatus::class,
    ];

    protected $appends = ['created_date', 'remaining_days', 'contract_start_date_text', 'contract_end_date_text', 'closing_date_text'];

    public function getContractStartDateAttribute()
    {
        return Carbon::parse($this->attributes['contract_start_date'])->format('m/d/Y');
    }

    public function getContractEndDateAttribute()
    {
        return Carbon::parse($this->attributes['contract_end_date'])->format('m/d/Y');
    }

    public function getClosingDateAttribute()
    {
        return Carbon::parse($this->attributes['closing_date'])->format('m/d/Y');
    }

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getContractStartDateTextAttribute()
    {
        return Carbon::parse($this->contract_start_date)->format('d M, Y');
    }

    public function getContractEndDateTextAttribute()
    {
        return Carbon::parse($this->contract_end_date)->format('d M, Y');
    }

    public function getClosingDateTextAttribute()
    {
        return Carbon::parse($this->closing_date)->format('d M, Y');
    }

    public function isPublished()
    {
        return $this->status->value == TenderStatus::IN_PROGRESS->value;
    }

    public function getRemainingDaysAttribute()
    {
        $closeDate = Carbon::parse($this->closing_date);
        $now = Carbon::today();

        return $closeDate->diffInDays($now);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TenderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function workCategoryClassification(): BelongsTo
    {
        return $this->belongsTo(WorkCategoryClassification::class, 'category_id', 'id');
    }

    public function activityClassification(): BelongsTo
    {
        return $this->belongsTo(ActivityClassification::class, 'activity_id', 'id');
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
