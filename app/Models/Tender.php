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
        'contract_start_date' => 'datetime',
        'contract_end_date' => 'datetime',
        'closing_date' => 'datetime',
    ];

    protected $appends = ['created_date', 'remaining_days', 'contract_start_date_text', 'contract_end_date_text', 'closing_date_text'];

    public function getContractStartDateTextAttribute()
    {
        return $this->contract_start_date ? $this->contract_start_date->format('d M, Y') : null;
    }

    public function getContractEndDateTextAttribute()
    {
        return $this->contract_end_date ? $this->contract_end_date->format('d M, Y') : null;
    }

    public function getClosingDateTextAttribute()
    {
        return $this->closing_date ? $this->closing_date->format('d M, Y') : null;
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d') : null;
    }

    public function isPublished()
    {
        return $this->status->value == TenderStatus::IN_PROGRESS->value;
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->closing_date) {
            return null;
        }
        
        return $this->closing_date->diffInDays(Carbon::today());
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
