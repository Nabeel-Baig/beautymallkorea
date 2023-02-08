<?php

namespace App\Http\Resources\Api\Product;

use App\Models\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see OptionValue */
class ProductOptionListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray($request): array {
		$this->collection->transform(static function (OptionValue $optionValue) {
			return new ProductOptionResource($optionValue);
		});

		return parent::toArray($request);
	}
}
