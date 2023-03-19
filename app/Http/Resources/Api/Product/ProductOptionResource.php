<?php

namespace App\Http\Resources\Api\Product;

use App\Models\ProductOption;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ProductOption */
class ProductOptionResource extends JsonResource {
	final public function toArray($request): array {
		return [
			"quantity" => $this->quantity,
			"subtract_stock" => $this->subtract_stock,
			"price_difference" => $this->price_difference,
			"price_adjustment" => $this->price_adjustment,

			"optionValue" => new OptionValueResource($this->whenLoaded("optionValue")),
		];
	}
}
