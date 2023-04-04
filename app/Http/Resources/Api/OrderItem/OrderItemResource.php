<?php

namespace App\Http\Resources\Api\OrderItem;

use App\Enums\DimensionClass;
use App\Enums\WeightClass;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrderItem */
class OrderItemResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"product_name" => $this->product_name,
			"product_option_name" => $this->product_option_name,
			"product_quantity" => $this->product_quantity,
			"product_weight" => $this->product_weight,
			"product_weight_class" => WeightClass::formattedName($this->product_weight_class),
			"product_dimension" => $this->product_dimension,
			"product_dimension_class" => DimensionClass::formattedName($this->product_dimension_class),
			"product_image" => $this->product_image,
			"product_price" => $this->product_price,
			"product_total_price" => $this->product_total_price,
		];
	}
}
