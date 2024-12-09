<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityClassificationTranslation extends Model
{
    use HasFactory;
    
    protected $table = 'activity_classification_translations';

    protected $fillable = ['activity_id', 'locale', 'name'];

    public $timestamps = false;
}
