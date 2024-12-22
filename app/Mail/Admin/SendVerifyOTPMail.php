<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerifyOTPMail extends Mailable
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
        $subject = 'QuoTech | User OTP Verify Email';

        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->to($this->email)
            ->subject($subject)
            ->view('admin.emails.otp.send-otp', compact('subject', 'data'));
    }
}
