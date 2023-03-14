<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductListRequest extends FormRequest {
	final public function rules(): array {
		return [
			// For sliders and stuff
			"latest" => ["nullable", "boolean"],
			"promotional" => ["nullable", "boolean"],

			// Result set size selection
			"paginate" => ["nullable", "boolean"],
			"numOfProducts" => ["nullable", "numeric"],

			// Relationships to fetch along
			"with" => ["nullable", "array"],
			"with.*" => ["string", "in:brand,tags"],

			// Basic product filters
			"productName" => ["nullable", "string"],
			"productPriceFrom" => ["nullable", "numeric"],
			"productPriceTo" => ["nullable", "numeric"],

			// Product brand filters
			"productOfBrands" => ["nullable", "array"],
			"productOfBrands.*" => ["string"],

			// Product category filters
			"productOfCategories" => ["nullable", "array"],
			"productOfCategories.*" => ["string"],
		];
	}
}
