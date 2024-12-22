<?php

namespace App\Services\Web;

use App\Enums\UserType;
use App\Mail\Admin\SendCompanyVerifyOTPMail;
use App\Mail\Admin\SendVerifyOTPMail;
use App\Models\User;
use App\Services\SettingService;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\DB;
use Mail;

readonly class AuthService
{
    public function __construct(
        private readonly OTPService $oTPService,
        private readonly SettingService $settingService,
        private readonly UserService $userService,
    ) {}

    // Register New User
    public function register(array $data)
    {
        if ($data['account_type'] == UserType::INDIVIDUAL->value) {
            $user = $this->registerIndividual($data);
        } else if ($data['account_type'] == UserType::COMPANY->value) {
            $user = $this->registerCompany($data);
        }

        return $user;
    }

    // Register New Individual User
    public function registerIndividual(array $data)
    {
        $otp = $this->oTPService->generateUserOTP();

        DB::beginTransaction();

        $user = new User();

        $user->full_name = $data['full_name'];
        $user->email = $data['email_individual'];
        $user->country_id = $data['country_id_individual'];
        $user->type = $data['account_type'];
        $user->password = Hash::make($data['individual_password']);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(3);

        $user->save();

        $otpData = [
            'date' => Carbon::today()->format('d M, Y'),
            'name' => $user->full_name,
            'otp' => $user->otp,
            'administratorEmail' => $this->settingService->getByKey('email')->value,
        ];

        Mail::to($user->email)->send(new SendVerifyOTPMail($otpData, $user->email));

        DB::commit();

        return $user;
    }

    // Register New Company User
    public function registerCompany(array $data)
    {
        $otp = $this->oTPService->generateUserOTP();

        DB::beginTransaction();

        $user = new User();

        $user->company_name = $data['company_name'];
        $user->email = $data['email_company'];
        $user->country_id = $data['country_id_company'];
        $user->type = $data['account_type'];
        $user->password = Hash::make($data['company_password']);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(3);

        $user->save();

        $otpData = [
            'date' => Carbon::today()->format('d M, Y'),
            'name' => $user->company_name,
            'otp' => $user->otp,
            'administratorEmail' => $this->settingService->getByKey('email')->value,
        ];

        Mail::to($user->email)->send(new SendCompanyVerifyOTPMail($otpData, $user->email));

        DB::commit();

        return $user;
    }

    // Verify User OTP
    public function verifyOTP(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->getUserByID($data['otp_user']);

            if (!$user) {
                DB::rollBack();
                return ['error' => 'Invalid - User not exists'];
            }

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

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Resend User OTP
    public function resendOTP(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->getUser($data['forget_password_search']);

            if (!$user) {
                DB::rollBack();
                return ['error' => 'Invalid - User not exists'];
            }

            $otp = $this->oTPService->generateUserOTP();

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(3)
            ]);

            $otpData = [
                'date' => Carbon::today()->format('d M, Y'),
                'name' => $user->company_name ?? $user->full_name,
                'otp' => $user->otp,
                'administratorEmail' => $this->settingService->getByKey('email')->value,
            ];

            if ($user->type->value == UserType::INDIVIDUAL->value) {
                Mail::to($user->email)->send(new SendVerifyOTPMail($otpData, $user->email));
            } else if ($user->type->value == UserType::COMPANY->value) {
                Mail::to($user->email)->send(new SendCompanyVerifyOTPMail($otpData, $user->email));
            }

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Reset User Password
    public function resetPassword(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->getUserByID($data['otp_user']);

            if (!$user) {
                DB::rollBack();
                return ['error' => 'Invalid - User not exists'];
            }

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

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }
}
