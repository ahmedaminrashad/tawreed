<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionReasonTranslation extends Model
{
    use HasFactory;

    protected $table = 'rejection_reason_translations';

    protected $fillable = ['rejection_id', 'locale', 'name'];

    public $timestamps = false;
}
