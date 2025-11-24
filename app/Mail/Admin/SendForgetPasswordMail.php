<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token, $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'QuoTech | Password Reset Link';
        $url = route('admin.reset.password.form', $this->token);

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to($this->email)
            ->subject($subject)
            ->view('admin.emails.password.reset', compact('subject', 'url'));
    }
}
