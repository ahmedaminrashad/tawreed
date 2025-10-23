<?php

namespace App\Services\Web;

use App\Enums\UserType;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

readonly class AuthService
{
    public function __construct(
        private readonly OTPService $oTPService,
        private readonly UserService $userService,
        private readonly EmailService $emailService,
    ) {}

    // Login User
    public function login(array $data, $userIP)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->getUser($data['login_text']);

            if (!$user) {
                DB::rollBack();
                return ['error' => __('auth.invalid_credentials')];
            }

//            if (!$user->email_verified_at) {
//                DB::rollBack();
//                return ['error' => __('auth.email_not_verified')];
//            }

            $credentials = $this->credentials($data['login_text'], $data['login_password']);

            if (!Auth::guard('web')->attempt($credentials)) {
                return ['error' => __('auth.invalid_credentials')];
            }

            $user = Auth::guard('web')->user();

            $response['user'] = new UserResource($user);

            $user->userDevices()->updateOrCreate(['uuid' => $userIP]);

            DB::commit();

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Register New User
    public function register(array $data)
    {
        if ($data['account_type'] == UserType::INDIVIDUAL->value) {
            $result = $this->registerIndividual($data);
        } else if ($data['account_type'] == UserType::COMPANY->value) {
            $result = $this->registerCompany($data);
        }

        if (is_object($result) || $result instanceof User) {
            return $result;
        }

        return ['error' => $result['error']];
    }

    // Register New Individual User
    public function registerIndividual(array $data)
    {
        try {
            $otp = $this->oTPService->generateUserOTP();

            DB::beginTransaction();

            $user = User::updateOrCreate(
                [
                    'email' => $data['email_individual'],
                ],
                [
                    'full_name' => $data['full_name'],
                    'type' => $data['account_type'],
                    'country_id' => $data['country_id_individual'],
                    'password' => Hash::make($data['individual_password']),
                    'otp' => $otp,
                    'otp_expires_at' => Carbon::now()->addMinutes(3),
                ]
            );

            $this->emailService->sendUserOTPEmail($user);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Register New Company User
    public function registerCompany(array $data)
    {
        try {
            $otp = $this->oTPService->generateUserOTP();

            DB::beginTransaction();

            $user = User::updateOrCreate(
                [
                    'email' => $data['email_company'],
                    'commercial_registration_number' => $data['crn'],
                ],
                [
                    'company_name' => $data['company_name'],
                    'type' => $data['account_type'],
                    'country_id' => $data['country_id_company'],
                    'password' => Hash::make($data['company_password']),
                    'otp' => $otp,
                    'otp_expires_at' => Carbon::now()->addMinutes(3),
                ]
            );

            $this->emailService->sendUserOTPEmail($user);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Logout User
    public function logout($userIP)
    {
        try {
            DB::beginTransaction();

            Auth::guard('web')->user()->userDevices()->where('uuid', $userIP)->delete();

            Auth::guard('web')->user()->tokens()->delete();

            Auth::guard('web')->logout();

            DB::commit();

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Verify User OTP
    public function verifyOTP(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->getUserByID($data['otp_user']);

            if (!$user) {
                DB::rollBack();
                return ['error' => __('auth.user_not_found')];
            }

            if ($user->otp != $data['otp']) {
                DB::rollBack();
                return ['error' => __('auth.otp_invalid')];
            }

            if ($user->otp_expires_at <= Carbon::now()->toDateTimeString()) {
                DB::rollBack();
                return ['error' => __('auth.otp_expired')];
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

            $user = $this->userService->getUserByID($data['resend_otp_user']);

            if (!$user) {
                DB::rollBack();
                return ['error' => __('auth.user_not_found')];
            }

            $otp = $this->oTPService->generateUserOTP();

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(3),
            ]);

            $this->emailService->sendUserOTPEmail($user);

            DB::commit();

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Forget User Password
    public function forgetPassword(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->getUser($data['forget_password_search']);

            if (!$user) {
                DB::rollBack();
                return ['error' => __('auth.user_not_found')];
            }

            $otp = $this->oTPService->generateUserOTP();

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(3)
            ]);

            $this->emailService->sendUserOTPEmail($user);

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
                return ['error' => __('auth.user_not_found')];
            }

            if ($user->otp != $data['otp']) {
                DB::rollBack();
                return ['error' => __('auth.otp_invalid')];
            }

            if ($user->otp_expires_at <= Carbon::now()->toDateTimeString()) {
                DB::rollBack();
                return ['error' => __('auth.otp_expired')];
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

    private function credentials($username, $password): array
    {
        if (is_numeric($username)) {
            return ['commercial_registration_number' => $username, 'password' => $password];
        }

        return ['email' => $username, 'password' => $password];
    }

    private function generateToken(User|Authenticatable $user): string
    {
        return $user->createToken('quotech')->plainTextToken;
    }
}
