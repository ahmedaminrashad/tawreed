<?php

namespace App\Services\Web;

use App\Mail\Admin\SendCompanyVerifyOTPMail;
use App\Mail\Admin\SendVerifyOTPMail;
use App\Mail\Admin\WelcomeMail;
use App\Models\User;
use App\Services\SettingService;
use Carbon\Carbon;
use Mail;

readonly class EmailService
{
    public function __construct(
        private readonly SettingService $settingService,
    ) {}

    // Send User Email
    public function sendUserOTPEmail(User $user)
    {
        $otpData = [
            'date' => Carbon::today()->format('d M, Y'),
            'name' => $user->isCompany() ? $user->company_name : $user->full_name,
            'otp' => $user->otp,
            'administratorEmail' => $this->settingService->getByKey('email')->value,
            'locale' => app()->getLocale(), // Pass current locale for email
        ];

        // Use send() instead of queue() for OTP emails since they're time-sensitive
        // and users need them immediately for verification
        if ($user->isCompany()) {
            Mail::to($user->email)->send(new SendCompanyVerifyOTPMail($otpData, $user->email));
        } else {
            Mail::to($user->email)->send(new SendVerifyOTPMail($otpData, $user->email));
        }
    }

    // Send Welcome Email
    public function sendWelcomeEmail(User $user)
    {
        $welcomeData = [
            'date' => Carbon::today()->format('d M, Y'),
            'name' => $user->isCompany() ? $user->company_name : $user->full_name,
            'administratorEmail' => $this->settingService->getByKey('email')->value,
            'locale' => app()->getLocale(), // Pass current locale for email
        ];

        Mail::to($user->email)->send(new WelcomeMail($welcomeData, $user->email));
    }
}
