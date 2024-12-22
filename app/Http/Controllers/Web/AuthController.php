<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OTPRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Services\Web\AuthService;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use CustomResponse;

    public function __construct(
        private readonly AuthService $authService,
    ) {}

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        // return $this->success($data, 'DDDDDDDDDDDDDDDD');

        $user = $this->authService->register($data);

        $response['user'] = new UserResource($user);

        return $this->success($response, 'User created successfully');
    }

    public function verifyOTP(OTPRequest $request)
    {
        $data = $request->validated();
        // return $this->success($data, 'VVVVVVVVVVVVV');

        $response = $this->authService->verifyOTP($data);
        // dd($response);

        if (is_array($response)) {
            return $this->failure(['error' => $response['error']], 'Error in verify User OTP');
        }

        return $this->success([], 'User verified successfully');
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $data = $request->validated();
        // return $this->success($data, 'Resennnnnd');

        $response = $this->authService->forgetPassword($data);

        if (is_array($response)) {
            return $this->failure(['error' => $response['error']], 'Error in resend User OTP');
        }

        return $this->success(['user' => $response], 'User OTP resend successfully');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        // return $this->success($data, 'Reset');

        $response = $this->authService->resetPassword($data);

        if ($response != 1) {
            return $this->failure(['error' => $response['error']], 'Error in resend User OTP');
        }

        return $this->success([], 'User Password reset successfully');
    }
}
