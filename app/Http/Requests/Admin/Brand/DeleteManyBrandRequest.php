<?php

namespace App\Http\Requests\Admin\Brand;

use Illuminate\Foundation\Http\FormRequest;

class DeleteManyBrandRequest extends FormRequest {
	final public function rules(): array {
		return [
			"ids" => "required|array",
			"ids.*" => "numeric",
		];
	}
}
