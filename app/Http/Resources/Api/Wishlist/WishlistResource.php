<?php

namespace App\Http\Resources\Api\Wishlist;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Wishlist */
class WishlistResource extends JsonResource {
	final public function toArray(Request $request): array {
		return [
			"id" => $this->id,
			"customer_id" => $this->customer_id,
			"product_id" => $this->product_id,
			"product_option_id" => $this->product_option_id,
		];
	}
}
