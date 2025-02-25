<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    use HasFactory;

    public $table = 'proposals';

    protected $guarded = ['id'];

    protected $casts = [
        // 'status' => TenderStatus::class,
    ];

    protected $appends = ['proposal_end_date_text'];

    public function items(): HasMany
    {
        return $this->hasMany(ProposalItem::class);
    }

    public function getProposalEndDateTextAttribute()
    {
        return Carbon::parse($this->proposal_end_date)->format('d M, Y');
    }
}
