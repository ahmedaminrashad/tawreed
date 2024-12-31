<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenderItem extends Model
{
    use HasFactory;

    public $table = 'tender_items';

    protected $guarded = ['id'];

    public function media(): HasMany
    {
        return $this->hasMany(TenderItem::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(MeasurementUnit::class, 'unit_id', 'id');
    }
}
