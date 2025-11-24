<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCompanyVerifyOTPMail extends Mailable
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
        $subject = 'QuoTech | Company OTP Verify Email';

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to($this->email)
            ->subject($subject)
            ->view('admin.emails.otp.send-otp', compact('subject', 'data'));
    }
}
