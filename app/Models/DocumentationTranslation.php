<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentationTranslation extends Model
{
    use HasFactory;

    protected $table = 'documentation_translations';

    protected $fillable = ['documentation_id', 'locale', 'page'];

    public $timestamps = false;
}
