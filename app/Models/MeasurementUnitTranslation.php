<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnitTranslation extends Model
{
    use HasFactory;

    protected $table = 'unit_translations';

    protected $fillable = ['unit_id', 'locale', 'name'];

    public $timestamps = false;
}
