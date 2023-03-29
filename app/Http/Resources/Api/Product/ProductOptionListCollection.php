<?php

namespace App\Http\Resources\Api\Product;

use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see ProductOption */
class ProductOptionListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (ProductOption $productOption) {
			return new ProductOptionResource($productOption);
		});

		return parent::toArray($request);
	}
}
