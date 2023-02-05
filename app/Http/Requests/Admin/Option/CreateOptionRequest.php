<?php

namespace App\Http\Requests\Admin\Option;

use Illuminate\Foundation\Http\FormRequest;

class CreateOptionRequest extends FormRequest {
	final public function rules(): array {
		return [
			"name" => "required|string|max:100",
			"option_values" => "required|array",
			"option_values.*.name" => "required|string",
			"option_values.*.image" => "nullable|image",
			"option_values.*.old_image" => "nullable|string",
		];
	}
}
