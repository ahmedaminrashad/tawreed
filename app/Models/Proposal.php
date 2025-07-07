<?php

namespace App\Models;

use App\Enums\ProposalStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    use HasFactory;

    public $table = 'proposals';

    protected $guarded = ['id'];

    protected $casts = [
        // 'status' => ProposalStatus::class,
    ];

    protected $appends = ['proposal_end_date_text', 'total_with_vat'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProposalItem::class);
    }

    public function getProposalEndDateTextAttribute()
    {
        return Carbon::parse($this->proposal_end_date)->format('d M, Y');
    }

    public function checkStatus()
    {
        return Carbon::now() > $this->proposal_end_date ? 'Closed' : 'In Progress';
    }

    public function getStatusText()
    {
        $final = str_replace(' ', '_', $this->status);
        $final = str_replace('(', '', $final);
        $final = str_replace(')', '', $final);
        
        return $final;
    }

    public function isCreator()
    {
        return $this->user_id == auth()->id();
    }

    public function isTenderCreator()
    {
        return $this->tender->user_id == auth()->id();
    }

    public function isUnderReview()
    {
        return $this->status == ProposalStatus::UNDER_REVIEW->value;
    }

    public function isInitialAccept()
    {
        return $this->status == ProposalStatus::INITIAL_ACCEPTANCE->value;
    }

    public function isSampleRequested()
    {
        return $this->status == ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_REQUESTED->value;
    }

    public function isSampleRequestSent()
    {
        return $this->status == ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_SENT->value;
    }

    public function isWithdrawn()
    {
        return $this->status == ProposalStatus::WITHDRAWN->value;
    }

    public function isRejected()
    {
        return $this->status == ProposalStatus::REJECTED->value;
    }

    public function isFinallyAccepted()
    {
        return $this->status == ProposalStatus::FINAL_ACCEPTANCE->value;
    }

    public function getStatusLabel()
    {
        return ProposalStatus::from($this->status)->getLabel();
    }

    public function getTotalWithVatAttribute()
    {
        $total_fromated= $this->total * (1 + config('app.vat'));
        return number_format($total_fromated, 2);
    }
}
