<?php

namespace App\Http\Requests\Api\Wishlist;

use Illuminate\Foundation\Http\FormRequest;

class CreateWishlistRequest extends FormRequest {
	final public function rules(): array {
		return [
			"product_id" => ["required", "numeric"],
			"product_option_id" => ["required", "numeric"],
		];
	}
}
