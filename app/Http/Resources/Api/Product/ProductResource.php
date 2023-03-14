<?php

namespace App\Http\Resources\Api\Product;

use App\Http\Resources\Api\Brand\BrandResource;
use App\Http\Resources\Api\Tag\TagListCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray($request): array {
		return [
			"name" => $this->name,
			"slug" => $this->slug,
			"price" => $this->price,
			"discount_price" => $this->discount_price,
			"image" => $this->image,

			"tags" => new TagListCollection($this->whenLoaded("tags")),
			"brand" => new BrandResource($this->whenLoaded("brand")),
		];
	}
}
