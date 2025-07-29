<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProposalMedia extends Model
{
    use HasFactory;

    protected $table = 'proposal_media';

    protected $appends =['url'];

   protected $guarded =[];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
    public function getUrlAttribute()
    {
        if ($this->file)
            return Storage::disk('public')->url($this->file);
        return null;
    }
}
