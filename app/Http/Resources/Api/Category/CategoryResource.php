<?php

namespace App\Http\Resources\Api\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Category */
class CategoryResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray($request): array {
		return [
			"name" => $this->name,
			"description" => $this->description,
			"slug" => $this->slug,
			"image" => $this->image,
			"childrenCategories" => new CategoryListCollection($this->whenLoaded("childrenCategories")),
		];
	}
}
