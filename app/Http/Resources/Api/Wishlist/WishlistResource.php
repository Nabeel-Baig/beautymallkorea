<?php

namespace App\Http\Resources\Api\Wishlist;

use App\Http\Resources\Api\Product\ProductOptionResource;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Wishlist */
class WishlistResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"id" => $this->id,
			"product_id" => $this->product_id,
			"product_option_id" => $this->product_option_id,

			"product" => new ProductResource($this->whenLoaded("product")),
			"productOption" => new ProductOptionResource($this->whenLoaded("productOption")),
		];
	}
}
