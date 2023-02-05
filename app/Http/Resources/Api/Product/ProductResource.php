<?php

namespace App\Http\Resources\Api\Product;

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
		];
	}
}
