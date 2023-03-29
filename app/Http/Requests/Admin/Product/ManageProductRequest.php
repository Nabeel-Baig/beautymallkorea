<?php

namespace App\Http\Requests\Admin\Product;

use App\Enums\DimensionClass;
use App\Enums\ProductOptionUnitAdjustment;
use App\Enums\ProductPromotion;
use App\Enums\ProductShipping;
use App\Enums\ProductStockBehaviour;
use App\Enums\WeightClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ManageProductRequest extends FormRequest {
	final public function rules(): array {
		$product = $this->route("product");
		$uniqueValidationUpdateConstraint = $product === null ? "" : ",$product->id";
		$productImageValidationConstraint = [$product === null ? "required" : "nullable"];

		/**
		 * The input is taken as multidimensional array in separate keys
		 * to feed the input in different functions identified by key
		 */
		return [
			// Product
			"product" => ["required", "array"],
			"product.brand_id" => ["required", "exists:brands,id"],
			"product.name" => ["required", "string"],
			"product.description" => ["required", "string"],
			"product.meta.meta_title" => ["nullable", "string"],
			"product.meta.meta_description" => ["nullable", "string"],
			"product.meta.meta_keywords" => ["nullable", "string"],
			"product.sku" => ["required", "string", "unique:products,sku$uniqueValidationUpdateConstraint"],
			"product.upc" => ["required", "string", "unique:products,upc$uniqueValidationUpdateConstraint"],
			"product.price" => ["required", "numeric"],
			"product.discount_price" => ["nullable", "numeric"],
			"product.quantity" => ["required", "numeric"],
			"product.dimension.dimension_length" => ["required", "numeric"],
			"product.dimension.dimension_width" => ["required", "numeric"],
			"product.dimension.dimension_height" => ["required", "numeric"],
			"product.dimension_class" => ["required", new Enum(DimensionClass::class)],
			"product.weight" => ["required", "numeric"],
			"product.weight_class" => ["required", new Enum(WeightClass::class)],
			"product.min_order_quantity" => ["required", "numeric"],
			"product.subtract_stock" => ["required", new Enum(ProductStockBehaviour::class)],
			"product.require_shipping" => ["required", new Enum(ProductShipping::class)],
			"product.promotion_status" => ["required", new Enum(ProductPromotion::class)],
			// ==============================================================================================

			// Product Images
			"product.image" => [...$productImageValidationConstraint, "image"],
			"product.old_image" => ["nullable", "string"],

			"product.secondary_images" => ["nullable", "array"],
			"product.secondary_images.*" => ["required", "image"],

			"product.old_secondary_images" => ["nullable", "array"],
			"product.old_secondary_images.*" => ["required", "string"],
			// ==============================================================================================

			// Product Options
			"options" => ["nullable", "array"],
			"options.*.option_value_id" => ["required", "numeric"],
			"options.*.quantity" => ["required", "numeric"],
			"options.*.subtract_stock" => ["nullable", new Enum(ProductStockBehaviour::class)],
			"options.*.price_difference" => ["nullable", "numeric"],
			"options.*.price_adjustment" => ["nullable", new Enum(ProductOptionUnitAdjustment::class)],
			"options.*.weight_difference" => ["nullable", "numeric"],
			"options.*.weight_adjustment" => ["nullable", new Enum(ProductOptionUnitAdjustment::class)],
			// ==============================================================================================

			// Product Tags
			"tags" => ["nullable", "array"],
			"tags.*" => ["required", "numeric"],
			// ==============================================================================================

			// Product Related Suggestions
			"related_products" => ["nullable", "array"],
			"related_products.*" => ["required", "numeric"],
			// ==============================================================================================

			// Product Categories
			"categories" => ["nullable", "array"],
			"categories.*" => ["required", "numeric"],
			// ==============================================================================================
		];
	}
}
