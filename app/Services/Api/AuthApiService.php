<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\SignInRequest;
use App\Http\Requests\Api\Auth\SignUpRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\JWTGuard;

class AuthApiService {
	final public function signInCustomer(SignInRequest $signInRequest): ?string {
		$customer = $this->validateCustomer($signInRequest);

		if ($customer === null) {
			return null;
		}

		$customer->updateCurrentActiveIp()->save();

		return $this->createAccessToken($customer);
	}

	final public function signUpCustomer(SignUpRequest $signUpRequest): string {
		$customer = $this->createNewCustomer($signUpRequest);

		return $this->createAccessToken($customer);
	}

	final public function signOutCustomer(): void {
		$customer = $this->getAuthenticatedCustomer($guard = $this->getAuthGuard());

		$customer->updateCurrentActiveIp()->save();
		$guard->logout();
	}

	final public function refreshCustomer(): string {
		return $this->getAuthGuard()->refresh();
	}

	final public function changePassword(ChangePasswordRequest $changePasswordRequest): string {
		$customer = $this->getAuthenticatedCustomer($guard = $this->getAuthGuard());

		$customer->updatePassword($changePasswordRequest->input("password"))->save();
		$guard->logout();

		return $this->createAccessToken($customer);
	}

	final public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): string {
		return Password::broker("customers")->sendResetLink($forgotPasswordRequest->validated());
	}

	final public function resetPassword(ResetPasswordRequest $resetPasswordRequest): string {
		return Password::broker("customers")->reset($resetPasswordRequest->validated(), static function (Customer $customer, string $password) {
			$customer->updatePassword($password)->save();
		});
	}

	final public function getAuthenticatedCustomer(JWTGuard $guard = null): Customer {
		$guard ??= $this->getAuthGuard();

		$customer = $guard->user();
		assert($customer instanceof Customer);

		return $customer;
	}

	private function validateCustomer(SignInRequest $signInRequest): ?Customer {
		$customer = Customer::whereEmail($signInRequest->input("email"))->first();
		if (!$customer) {
			return null;
		}

		return $customer->verifyPassword($signInRequest->input("password")) ? $customer : null;
	}

	private function createNewCustomer(SignUpRequest $signUpRequest): Customer {
		$createCustomerData = $signUpRequest->validated();
		$createCustomerData = handleFiles("customers", $createCustomerData);

		return Customer::create($createCustomerData);
	}

	private function createAccessToken(Customer $customer): string {
		return $this->getAuthGuard()->login($customer);
	}

	private function getAuthGuard(): JWTGuard {
		$jwtGuard = auth("jwt");
		assert($jwtGuard instanceof JWTGuard);

		return $jwtGuard;
	}
}
