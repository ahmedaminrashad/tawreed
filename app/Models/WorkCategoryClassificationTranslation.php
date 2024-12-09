<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCategoryClassificationTranslation extends Model
{
    use HasFactory;

    protected $table = 'classification_translations';

    protected $fillable = ['classification_id', 'locale', 'name'];

    public $timestamps = false;
}
