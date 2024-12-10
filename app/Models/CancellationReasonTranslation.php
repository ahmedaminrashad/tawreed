<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationReasonTranslation extends Model
{
    use HasFactory;

    protected $table = 'cancellation_reason_translations';

    protected $fillable = ['cancellation_id', 'locale', 'name'];

    public $timestamps = false;
}
