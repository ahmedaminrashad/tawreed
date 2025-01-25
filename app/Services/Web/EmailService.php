<?php

namespace App\Services\Web;

use App\Mail\Admin\SendCompanyVerifyOTPMail;
use App\Mail\Admin\SendVerifyOTPMail;
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
        ];

        if ($user->isCompany()) {
            Mail::to($user->email)->send(new SendCompanyVerifyOTPMail($otpData, $user->email));
        } else {
            Mail::to($user->email)->send(new SendVerifyOTPMail($otpData, $user->email));
        }
    }
}
