<?php

namespace App\Services\Web;

use App\Models\User;

readonly class OTPService
{
    // Generate Random OTP 6 digits for User Model
    public function generateUserOTP()
    {
        $otp = $this->generate();

        if ($this->checkUserOTP($otp)) {
            return $this->generateUserOTP();
        }

        return $otp;
    }

    // Check User OTP
    private function checkUserOTP($otp)
    {
        return User::where('otp', $otp)->exists();
    }

    // Generate Random OTP 6 digits
    private function generate()
    {
        return random_int(100000, 999999);
    }
}
