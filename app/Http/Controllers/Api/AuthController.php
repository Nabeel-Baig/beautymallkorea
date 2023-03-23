<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\CustomerSignInRequest;
use App\Http\Requests\Api\Auth\CustomerSignUpRequest;
use App\Http\Resources\Api\Auth\AuthenticatedResponse;
use App\Services\Api\CustomerAuthService;

class AuthController extends Controller {
	public function __construct(private readonly CustomerAuthService $customerAuthService) {}

	final public function signIn(CustomerSignInRequest $customerSignInRequest): AuthenticatedResponse {
		$accessToken = $this->customerAuthService->signInCustomer($customerSignInRequest);

		return new AuthenticatedResponse($accessToken);
	}

	final public function signUp(CustomerSignUpRequest $customerSignUpRequest): AuthenticatedResponse {
		$accessToken = $this->customerAuthService->signUpCustomer($customerSignUpRequest);

		return new AuthenticatedResponse($accessToken);
	}

	final public function signOut(): void {
		$this->customerAuthService->signOutCustomer();
	}

	final public function refresh(): void {
		$this->customerAuthService
	}
}
