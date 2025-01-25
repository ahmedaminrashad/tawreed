<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OTPRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResendOTPRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Web\AuthService;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use CustomResponse;

    public function __construct(
        private readonly AuthService $authService,
    ) {}

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $userIP = $request->ip();

        $response = $this->authService->login($data, $userIP);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], 'Error in Login User');
        }

        return $this->success($response, 'User Logged in successfully');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $result = $this->authService->register($data);

        if (is_object($result) || $result instanceof User) {
            $response['user'] = new UserResource($result);

            return $this->success($response, 'User created successfully');
        }

        return $this->failure(['error' => $result['error']], 'Error in create User');
    }

    public function verifyOTP(OTPRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->verifyOTP($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], 'Error in verify User OTP');
        }

        return $this->success([], 'User verified successfully');
    }

    public function resendOTP(ResendOTPRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->resendOTP($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], 'Error in resend User OTP');
        }

        return $this->success([], 'User OTP resend successfully');
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->forgetPassword($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], 'Error in resend User OTP');
        }

        return $this->success(['user' => $response], 'User OTP resend successfully');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->resetPassword($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], 'Error in resend User OTP');
        }

        return $this->success([], 'User Password reset successfully');
    }

    public function logout(Request $request)
    {
        $userIP = $request->ip();
        // return $this->success($data, 'Logiiiiiiiiiiiiiiiiiin');

        $response = $this->authService->logout($userIP);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], 'Error in Logout User');
        }

        return $this->success([], 'User Logged out successfully');
    }
}
