<?php

namespace App\Services\Web;

use App\Enums\UserType;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\QueryException;
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
        $result = null;

        if ($data['account_type'] == UserType::INDIVIDUAL->value) {
            $result = $this->registerIndividual($data);
        } else if ($data['account_type'] == UserType::COMPANY->value) {
            $result = $this->registerCompany($data);
        } else {
            return ['error' => __('auth.invalid_account_type')];
        }

        if (is_object($result) || $result instanceof User) {
            return $result;
        }

        if (is_array($result) && isset($result['error'])) {
            return ['error' => $result['error']];
        }

        return ['error' => __('auth.register_error')];
    }

    // Register New Individual User
    public function registerIndividual(array $data)
    {
        try {
            $otp = $this->oTPService->generateUserOTP();

            DB::beginTransaction();

            // Check if email already exists
            $existingUser = User::where('email', $data['email_individual'])->first();
            if ($existingUser) {
                DB::rollBack();
                return ['error' => __('auth.email_already_registered')];
            }

            $user = User::create([
                'email' => $data['email_individual'],
                'full_name' => $data['full_name'],
                'type' => $data['account_type'],
                'country_id' => $data['country_id_individual'],
                'password' => Hash::make($data['individual_password']),
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(3),
            ]);

            try {
                $this->emailService->sendUserOTPEmail($user);
            } catch (\Exception $emailException) {
                // Log email error but don't fail registration
                \Log::error('Failed to send OTP email: ' . $emailException->getMessage());
            }

            DB::commit();

            return $user;
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            // Handle database constraint violations
            if ($e->getCode() == 23000) { // Integrity constraint violation
                if (str_contains($e->getMessage(), 'email')) {
                    return ['error' => __('auth.email_already_registered')];
                }
                return ['error' => __('auth.database_error')];
            }
            return ['error' => __('auth.register_error')];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            return ['error' => __('auth.register_error')];
        }
    }

    // Register New Company User
    public function registerCompany(array $data)
    {
        try {
            $otp = $this->oTPService->generateUserOTP();

            DB::beginTransaction();

            // Check if email already exists
            $existingUserByEmail = User::where('email', $data['email_company'])->first();
            if ($existingUserByEmail) {
                DB::rollBack();
                return ['error' => __('auth.email_already_registered')];
            }

            // Check if CRN already exists
            $existingUserByCRN = User::where('commercial_registration_number', $data['crn'])->first();
            if ($existingUserByCRN) {
                DB::rollBack();
                return ['error' => __('auth.crn_already_registered')];
            }

            $user = User::create([
                'email' => $data['email_company'],
                'commercial_registration_number' => $data['crn'],
                'company_name' => $data['company_name'],
                'type' => $data['account_type'],
                'country_id' => $data['country_id_company'],
                'password' => Hash::make($data['company_password']),
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(3),
            ]);

            try {
                $this->emailService->sendUserOTPEmail($user);
            } catch (\Exception $emailException) {
                // Log email error but don't fail registration
                \Log::error('Failed to send OTP email: ' . $emailException->getMessage());
            }

            DB::commit();

            return $user;
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            // Handle database constraint violations
            if ($e->getCode() == 23000) { // Integrity constraint violation
                if (str_contains($e->getMessage(), 'email')) {
                    return ['error' => __('auth.email_already_registered')];
                }
                if (str_contains($e->getMessage(), 'commercial_registration_number')) {
                    return ['error' => __('auth.crn_already_registered')];
                }
                return ['error' => __('auth.database_error')];
            }
            return ['error' => __('auth.register_error')];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            return ['error' => __('auth.register_error')];
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

            // Send welcome email after email verification
            $this->emailService->sendWelcomeEmail($user);

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
