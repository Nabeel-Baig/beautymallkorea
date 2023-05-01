<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Address\CreateAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Support\Collection;

class AddressApiService {
	public function __construct(private readonly AuthApiService $authApiService) {}

	final public function index(): Collection {
		return $this->authApiService->getAuthenticatedCustomer()->addresses;
	}

	final public function create(CreateAddressRequest $createAddressRequest): Address {
		$customer = $this->authApiService->getAuthenticatedCustomer();

		return $customer->addresses()->create($createAddressRequest->validated());
	}

	final public function update(UpdateAddressRequest $updateAddressRequest, Address $address): ?Address {
		$customer = $this->authApiService->getAuthenticatedCustomer();

		if ($customer->doesNotOwn($address, "customer_id")) {
			return null;
		}

		return $address->update($updateAddressRequest->validated()) ? $address : null;
	}

	final public function delete(Address $address): bool {
		$customer = $this->authApiService->getAuthenticatedCustomer();

		if ($customer->doesNotOwn($address, "customer_id")) {
			return false;
		}

		return $address->delete();
	}
}
