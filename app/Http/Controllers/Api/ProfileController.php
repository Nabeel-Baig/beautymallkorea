<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\UpdateCustomerInfoRequest;
use App\Http\Resources\Api\Customer\CustomerResource;
use App\Services\Api\ProfileApiService;

class ProfileController extends Controller {
	public function __construct(private readonly ProfileApiService $profileApiService) {}

	final public function index(): CustomerResource {
		$customer = $this->profileApiService->index();

		return new CustomerResource($customer);
	}

	final public function update(UpdateCustomerInfoRequest $updateCustomerInfoRequest): CustomerResource {
		$customer = $this->profileApiService->update($updateCustomerInfoRequest);

		return new CustomerResource($customer);
	}
}
