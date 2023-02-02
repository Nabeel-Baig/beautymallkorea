<?php

namespace App\Http\Resources\Api\Brand;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Brand */
class BrandListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray($request): array {
		$this->collection->transform(static function (Brand $brand) {
			return new BrandResource($brand);
		});

		return parent::toArray($request);
	}
}
