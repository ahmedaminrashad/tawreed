<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $email)
    {
        $this->data = $data;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $subject = 'QuoTech | Welcome to QuoTech';

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to($this->email)
            ->subject($subject)
            ->view('admin.emails.welcome.welcome', compact('subject', 'data'));
    }
}

