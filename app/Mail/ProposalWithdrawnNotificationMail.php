<?php

namespace App\Mail;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalWithdrawnNotificationMail extends Mailable
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
        $subject = 'QuoTech | Proposal Withdrawn Notification';

        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->to($this->data['tender_owner_email'])
            ->subject($subject)
            ->view('admin.emails.proposal.proposal-withdrawn', compact('subject', 'data'));
    }
}
