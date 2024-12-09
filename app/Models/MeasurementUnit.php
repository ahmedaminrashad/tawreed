<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeasurementUnit extends Model
{
    use HasFactory, Translatable;

    public $table = 'units';

    public $translatedAttributes = ['name'];

    protected $with = ['translations'];

    protected $guarded = ['id'];

    protected $appends = ['created_date'];

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(MeasurementUnitTranslation::class, 'unit_id', 'id');
    }

    public function translation(): HasMany
    {
        return $this->hasMany(MeasurementUnitTranslation::class, 'unit_id', 'id');
    }
}
