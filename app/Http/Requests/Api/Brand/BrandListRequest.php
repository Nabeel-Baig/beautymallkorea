<?php

namespace App\Http\Requests\Api\Brand;

use Illuminate\Foundation\Http\FormRequest;

class BrandListRequest extends FormRequest {
	final public function rules(): array {
		return [
			"name" => "nullable|string",
			"country" => "nullable|string",

			// For sliders and stuff
			"latest" => "nullable|boolean",

			// Result set size selection
			"paginate" => "nullable|boolean",
			"numOfBrands" => "nullable|numeric",
		];
	}
}
