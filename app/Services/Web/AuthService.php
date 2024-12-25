<?php

namespace App\Services\Web;

use App\Enums\UserType;
use App\Http\Resources\UserResource;
use App\Mail\Admin\SendCompanyVerifyOTPMail;
use App\Mail\Admin\SendVerifyOTPMail;
use App\Models\User;
use App\Services\SettingService;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Mail;

readonly class AuthService
{
    public function __construct(
        private readonly OTPService $oTPService,
        private readonly SettingService $settingService,
        private readonly UserService $userService,
    ) {}

    // Login User
    public function login(array $data, $userIP)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->getUser($data['login_text']);

            if (!$user) {
                DB::rollBack();
                return ['error' => 'Invalid - User not exists'];
            }

            if (!$user->email_verified_at) {
                DB::rollBack();
                return ['error' => 'Invalid - User not exists'];
            }

            $credentials = $this->credentials($data['login_text'], $data['login_password']);

            if (!Auth::guard('api')->attempt($credentials)) {
                return ['error' => 'Invalid Credentials'];
            }

            $user = Auth::guard('api')->user();

            $token = $this->generateToken($user);

            $response['user'] = new UserResource($user);

            $response['token'] = $token;
            
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

            $otpData = [
                'date' => Carbon::today()->format('d M, Y'),
                'name' => $user->full_name,
                'otp' => $user->otp,
                'administratorEmail' => $this->settingService->getByKey('email')->value,
            ];

            Mail::to($user->email)->send(new SendVerifyOTPMail($otpData, $user->email));

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

            Auth::guard('api')->user()->userDevices()->where('uuid', $userIP)->delete();

            Auth::guard('api')->user()->tokens()->delete();

            Auth::guard('api')->logout();

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

    // Forget User Password
    public function forgetPassword(array $data)
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
