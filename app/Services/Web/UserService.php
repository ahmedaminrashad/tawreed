<?php

namespace App\Services\Web;

use App\Models\User;
use Carbon\Carbon;
use DB;
use Hash;

readonly class UserService
{
    public function __construct(
        private readonly OTPService $oTPService,
        private readonly EmailService $emailService,
    ) {}

    // get User by ID function
    public function getUserByID($id)
    {
        $user = User::find($id);

        return $user;
    }

    // get User function
    public function getUser($text)
    {
        $user = User::where('email', $text)
            ->orWhere('commercial_registration_number', $text)
            ->first();

        return $user;
    }

    // Update User function
    public function update(User $user, $data)
    {
        try {
            DB::beginTransaction();

            $user->update($data);

            if (isset($data['category_id'])) {
                $user->userCategories()->sync($data['category_id']);
            }

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Update User Password function
    public function updatePassword(User $user, $data)
    {
        try {
            DB::beginTransaction();

            if (!Hash::check($data['old_password'], $user->password)) {
                return 0;
            }

            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Update User Email function
    public function updateEmail(User $user, $data)
    {
        try {
            $otp = $this->oTPService->generateUserOTP();

            DB::beginTransaction();

            $user->update([
                'email' => $data['new_email'],
                'email_verified_at' => null,
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(3),
            ]);

            $this->emailService->sendUserOTPEmail($user);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Verify update User Email function
    public function verifyEmailUpdate(User $user, $data)
    {
        try {
            DB::beginTransaction();

            if ($user->otp != $data['otp']) {
                DB::rollBack();
                return ['error' => 'Invalid OTP'];
            }

            if ($user->otp_expires_at <= Carbon::now()->toDateTimeString()) {
                DB::rollBack();
                return ['error' => 'OTP Expired'];
            }

            $user->update([
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }
}
