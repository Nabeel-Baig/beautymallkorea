<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductOptionPriceAdjustment;
use App\Enums\RequireShipping;
use App\Enums\SubtractStock;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManageProductRequest extends FormRequest {
	final public function rules(): array {
		$product = $this->route("product");
		$uniqueValidationUpdateConstraint = $product !== null ? ",$product->id" : "";

		$subtractStockPossibilities = array_map(static function (SubtractStock $subtractStock) {
			return $subtractStock->value;
		}, SubtractStock::cases());

		$requireShippingPossibilities = array_map(static function (RequireShipping $requireShipping) {
			return $requireShipping->value;
		}, RequireShipping::cases());

		$priceAdjustmentPossibilities = array_map(static function (ProductOptionPriceAdjustment $adjustment) {
			return $adjustment->value;
		}, ProductOptionPriceAdjustment::cases());

		/**
		 * The input is taken as multidimensional array in separate keys
		 * to feed the input in different functions identified by key
		 */
		return [
			"product" => "required|array",
			"product.name" => "required|string",
			"product.description" => "required|string",
			"product.meta_title" => "nullable|string",
			"product.meta_description" => "nullable|string",
			"product.meta_keywords" => "nullable|string",
			"product.sku" => "required|string|unique:products,sku$uniqueValidationUpdateConstraint",
			"product.upc" => "required|string|unique:products,upc$uniqueValidationUpdateConstraint",
			"product.price" => "required|numeric",
			"product.quantity" => "required|numeric",
			"product.image" => "nullable|image",
			"product.old_image" => "nullable|string",
			"product.secondary_images" => "nullable|array",
			"product.old_secondary_images" => "nullable|array",
			"product.min_order_quantity" => "nullable|numeric",
			"product.subtract_stock" => ["nullable", Rule::in($subtractStockPossibilities)],
			"product.require_shipping" => ["nullable", Rule::in($requireShippingPossibilities)],

			"options" => "nullable|array",
			"options.*.option_value_id" => "required|numeric",
			"options.*.quantity" => "required|numeric",
			"options.*.subtract_stock" => ["nullable", Rule::in($subtractStockPossibilities)],
			"options.*.price_difference" => "nullable|numeric",
			"options.*.price_adjustment" => ["nullable", Rule::in($priceAdjustmentPossibilities)],

			"tags" => "nullable|array",
			"tags.*" => "required|numeric",

			"related_products" => "nullable|array",
			"related_products.*" => "required|numeric",

			"categories" => "nullable|array",
			"categories.*" => "required|numeric",
		];
	}
}
