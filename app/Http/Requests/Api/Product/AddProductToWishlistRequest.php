<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;

class AddProductToWishlistRequest extends FormRequest {
	final public function rules(): array {
		return [
			"product_id" => ["required", "numeric"],
			"product_option_id" => ["required", "numeric"],
		];
	}
}
