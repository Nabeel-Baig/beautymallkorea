<?php

namespace App\Http\Resources\Api\Address;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Address */
class AddressListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (Address $address) {
			return new AddressResource($address);
		});

		return parent::toArray($request);
	}
}
