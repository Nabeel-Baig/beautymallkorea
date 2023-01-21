<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ManageProductRequest extends FormRequest {
	final public function rules(): array {
		$product = $this->route("product");
		$productPresent = $product !== null;

		$uniqueValidationConstraint = $productPresent ? ',' . $product->id : '';

		return [
			"product" => "required|array",

			"product.name" => "required|string",
			"product.description" => "nullable",
			"product.meta_title" => "nullable",
			"product.meta_description" => "nullable",
			"product.meta_keywords" => "nullable",
			"product.sku" => "required|unique:products,sku$uniqueValidationConstraint",
			"product.upc" => "required|unique:products,upc$uniqueValidationConstraint",
		];
	}
}
