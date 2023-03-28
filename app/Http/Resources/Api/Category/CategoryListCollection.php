<?php

namespace App\Http\Resources\Api\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Category */
class CategoryListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (Category $category) {
			return new CategoryResource($category);
		});

		return parent::toArray($request);
	}
}
