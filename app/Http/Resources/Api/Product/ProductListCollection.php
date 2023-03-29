<?php

namespace App\Http\Resources\Api\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Product */
class ProductListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (Product $product) {
			return new ProductResource($product);
		});

		return parent::toArray($request);
	}
}
