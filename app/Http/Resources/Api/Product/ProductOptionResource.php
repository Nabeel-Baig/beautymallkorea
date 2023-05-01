<?php

namespace App\Http\Resources\Api\Product;

use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ProductOption */
class ProductOptionResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"id" => $this->id,
			"quantity" => $this->quantity,
			"subtract_stock" => $this->subtract_stock,
			"price_difference" => $this->price_difference,
			"price_adjustment" => $this->price_adjustment,

			"optionValue" => new OptionValueResource($this->whenLoaded("optionValue")),
		];
	}
}
