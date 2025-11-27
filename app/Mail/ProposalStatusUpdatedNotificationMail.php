<?php

namespace App\Mail;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalStatusUpdatedNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $proposal;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(Proposal $proposal, $data)
    {
        $this->proposal = $proposal;
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $data = $this->data;
        
        // Set locale for email translation
        $locale = $data['locale'] ?? app()->getLocale();
        app()->setLocale($locale);
        
        $subject = __('web.proposal_status_updated_email_subject');

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to($this->data['proposal_owner_email'])
            ->subject($subject)
            ->view('admin.emails.proposal.proposal-status-updated', compact('subject', 'data'));
    }
}

