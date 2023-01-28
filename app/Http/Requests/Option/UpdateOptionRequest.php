<?php

namespace App\Http\Requests\Option;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOptionRequest extends FormRequest {
	final public function rules(): array {
		return [
			"name" => "required|string|max:100",
			"option_values" => "nullable|array",
			"option_values.*.id" => "nullable|numeric",
			"option_values.*.name" => "required|string",
			"option_values.*.image" => "nullable|image",
			"option_values.*.old_image" => "nullable|string",
		];
	}
}
