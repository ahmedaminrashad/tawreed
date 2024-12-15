<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documentation extends Model
{
    use HasFactory, Translatable;

    public $table = 'documentations';

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
        return $this->hasMany(DocumentationTranslation::class);
    }

    public function getKeyAttribute()
    {
        if ($this->attributes['key'] == 'about_us') {
            return 'About Us';
        } elseif ($this->attributes['key'] == 'privacy_policy') {
            return 'Privacy Policy';
        } elseif ($this->attributes['key'] == 'terms_conditions') {
            return 'Terms & Conditions';
        }
    }
}
