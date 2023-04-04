<?php

namespace App\Http\Resources\Api\Address;

use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

/** @mixin Address */
class AddressResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"id" => $this->id ?? null,
			"is_default" => $this->is_default ?? null,
			"address_line_one" => $this->address_line_one ?? null,
			"address_line_two" => $this->address_line_two ?? null,
			"address_city" => $this->address_city ?? null,
			"address_state" => $this->address_state ?? null,
			"address_country" => $this->address_country ?? null,
			"address_zip_code" => $this->address_zip_code ?? null,
		];
	}

	/**
	 * @param $request
	 *
	 * @return JsonResponse
	 */
	final public function toResponse($request): JsonResponse {
		$responseCode = $this->resource === null ? Response::HTTP_FORBIDDEN : Response::HTTP_OK;

		return parent::toResponse($request)->setStatusCode($responseCode);
	}
}
