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
            return $this->failure(['error' => $response['error']], __('auth.login_error'));
        }

        return $this->success($response, __('auth.login_success'));
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $result = $this->authService->register($data);

            if (is_object($result) || $result instanceof User) {
                $response['user'] = new UserResource($result);

                return $this->success($response, __('auth.register_success'));
            }

            // Handle error response
            $errorMessage = is_array($result) && isset($result['error']) 
                ? $result['error'] 
                : __('auth.register_error');

            return $this->failure(['error' => $errorMessage], __('auth.register_error'));
        } catch (\Exception $e) {
            \Log::error('Registration controller error: ' . $e->getMessage());
            return $this->failure(['error' => __('auth.register_error')], __('auth.register_error'));
        }
    }

    public function verifyOTP(OTPRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->verifyOTP($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], __('auth.otp_verify_error'));
        }

        return $this->success([], __('auth.otp_verify_success'));
    }

    public function resendOTP(ResendOTPRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->resendOTP($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], __('auth.otp_resend_error'));
        }

        return $this->success([], __('auth.otp_resend_success'));
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->forgetPassword($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], __('auth.password_reset_error'));
        }

        return $this->success(['user' => $response], __('auth.password_reset_mail_success'));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->resetPassword($data);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], __('auth.password_reset_error'));
        }

        return $this->success([], __('auth.password_reset_success'));
    }

    public function logout(Request $request)
    {
        $userIP = $request->ip();

        $response = $this->authService->logout($userIP);

        if (is_array($response) && array_key_exists('error', $response)) {
            return $this->failure(['error' => $response['error']], __('auth.logout_error'));
        }

        return $this->success([], __('auth.logout_success'));
    }
}
