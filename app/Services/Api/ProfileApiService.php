<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Customer\UpdateCustomerInfoRequest;
use App\Models\Customer;
use Illuminate\Support\Arr;

class ProfileApiService {
	public function __construct(private readonly AuthApiService $authApiService) {}

	final public function index(): Customer {
		return $this->authApiService->getAuthenticatedCustomer();
	}

	final public function update(UpdateCustomerInfoRequest $updateCustomerInfoRequest): Customer {
		$data = $updateCustomerInfoRequest->validated();
		$customer = $this->authApiService->getAuthenticatedCustomer();

		Arr::has($data, "profile_picture") ? $data = handleFiles("customers", $data) : $data["profile_picture"] = $data["profile_picture_old"];

		unset($data["profile_picture_old"]);
		$customer->update($data);

		return $customer;
	}
}
