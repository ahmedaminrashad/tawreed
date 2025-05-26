<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkCategoryClassification extends Model
{
    use HasFactory, Translatable;

    public $table = 'classifications';

    public $translatedAttributes = ['name'];

    protected $with = ['translations'];

    protected $guarded = ['id'];

    protected $appends = ['created_date', 'arabic_name'];

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getArabicNameAttribute()
    {
        return @$this->translate('ar')->name;
    }

    public function translations(): HasMany
    {
        return $this->hasMany(WorkCategoryClassificationTranslation::class, 'classification_id', 'id');
    }

    public function translation(): HasMany
    {
        return $this->hasMany(WorkCategoryClassificationTranslation::class, 'classification_id', 'id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityClassification::class, 'classification_id', 'id');
    }
}
