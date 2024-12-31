<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory, Translatable;

    public $table = 'countries';

    public $translatedAttributes = ['name'];

    protected $with = ['translations'];

    protected $guarded = ['id'];

    protected $appends = ['created_date'];

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function translation(): HasMany
    {
        return $this->hasMany(CountryTranslation::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function cities_list(): array
    {
        return $this->cities()->join(
            'city_translations',
            'cities.id',
            'city_translations.city_id'
        )
            ->select('city_translations.city_id as city_id', 'city_translations.name as city_name')
            ->pluck('city_name', 'city_id')->toArray();
    }
}
