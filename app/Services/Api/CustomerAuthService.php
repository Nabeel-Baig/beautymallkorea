<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Auth\CustomerSignInRequest;
use App\Http\Requests\Api\Auth\CustomerSignUpRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTGuard;

class CustomerAuthService {
	final public function signInCustomer(CustomerSignInRequest $customerSignInRequest): ?string {
		$customer = $this->validateCustomer($customerSignInRequest);

		if ($customer === null) {
			return null;
		}

		$customer->updateCurrentActiveIp()->save();

		return $this->createAccessToken($customer);
	}

	final public function signUpCustomer(CustomerSignUpRequest $customerSignUpRequest): string {
		$customer = $this->createNewCustomer($customerSignUpRequest);

		return $this->createAccessToken($customer);
	}

	final public function signOutCustomer(): void {
		$customer = auth("jwt")->user();
		if ($customer === null) {
			throw new HttpException(Response::HTTP_UNAUTHORIZED);
		}

		$customer->updateCurrentActiveIp()->save();

		auth("jwt")->logout();
	}

	final public function refreshCustomer() {
		// auth("jwt")->ref
	}

	private function validateCustomer(CustomerSignInRequest $customerSignInRequest): ?Customer {
		$customer = Customer::whereEmail($customerSignInRequest->input("email"))->first();
		if (!$customer) {
			return null;
		}

		$passwordVerified = Hash::check($customerSignInRequest->input("password"), $customer->password);
		return $passwordVerified ? $customer : null;
	}

	private function createNewCustomer(CustomerSignUpRequest $customerSignUpRequest): Customer {
		$createCustomerData = $customerSignUpRequest->validated();
		$createCustomerData = handleFiles("customers", $createCustomerData);

		return Customer::create($createCustomerData);
	}

	private function createAccessToken(Customer $customer): string {
		$jwtGuard = auth("jwt");
		assert($jwtGuard instanceof JWTGuard);

		return $jwtGuard->login($customer);
	}
}
