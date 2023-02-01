<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;

class GetProductsRequest extends FormRequest {
	final public function rules(): array {
		return [
			"latest" => "nullable|boolean",
			"promotional" => "nullable|boolean",
		];
	}
}
