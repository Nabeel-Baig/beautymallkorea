<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * @mixin string
 */
class AuthenticatedResponse extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"accessToken" => $this->resource,
		];
	}

	/**
	 * @param $request
	 *
	 * @return JsonResponse
	 */
	final public function toResponse($request): JsonResponse {
		$responseCode = $this->resource === null ? Response::HTTP_UNAUTHORIZED : Response::HTTP_OK;

		return parent::toResponse($request)->setStatusCode($responseCode);
	}
}
