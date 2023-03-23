<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\SignInRequest;
use App\Http\Requests\Api\Auth\SignUpRequest;
use App\Http\Resources\Api\Auth\AuthenticatedResponse;
use App\Services\Api\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller {
	public function __construct(private readonly AuthService $authService) {}

	final public function signIn(SignInRequest $signInRequest): AuthenticatedResponse {
		$accessToken = $this->authService->signInCustomer($signInRequest);

		return new AuthenticatedResponse($accessToken);
	}

	final public function signUp(SignUpRequest $signUpRequest): AuthenticatedResponse {
		$accessToken = $this->authService->signUpCustomer($signUpRequest);

		return new AuthenticatedResponse($accessToken);
	}

	final public function signOut(): JsonResponse {
		$this->authService->signOutCustomer();

		return response()->json(["logout" => true]);
	}

	final public function refresh(): AuthenticatedResponse {
		$accessToken = $this->authService->refreshCustomer();

		return new AuthenticatedResponse($accessToken);
	}

	final public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): JsonResponse {
		$resetLinkStatus = $this->authService->forgotPassword($forgotPasswordRequest);

		return response()->json(["message" => __($resetLinkStatus)]);
	}

	final public function resetPassword(ResetPasswordRequest $resetPasswordRequest): JsonResponse {
		$resetPasswordStatus = $this->authService->resetPassword($resetPasswordRequest);

		return response()->json(["message" => __($resetPasswordStatus)]);
	}
}
