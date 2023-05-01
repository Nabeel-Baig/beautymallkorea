<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Address\CreateAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Http\Resources\Api\Address\AddressListCollection;
use App\Http\Resources\Api\Address\AddressResource;
use App\Models\Address;
use App\Services\Api\AddressApiService;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller {
	public function __construct(private readonly AddressApiService $addressApiService) {}

	final public function index(): AddressListCollection {
		$addresses = $this->addressApiService->index();

		return new AddressListCollection($addresses);
	}

	final public function create(CreateAddressRequest $createAddressRequest): AddressResource {
		$address = $this->addressApiService->create($createAddressRequest);

		return new AddressResource($address);
	}

	final public function update(UpdateAddressRequest $updateAddressRequest, Address $address): AddressResource {
		$address = $this->addressApiService->update($updateAddressRequest, $address);

		return new AddressResource($address);
	}

	final public function delete(Address $address): JsonResponse {
		$addressDeleted = $this->addressApiService->delete($address);

		return response()->json(["data" => $addressDeleted]);
	}
}
