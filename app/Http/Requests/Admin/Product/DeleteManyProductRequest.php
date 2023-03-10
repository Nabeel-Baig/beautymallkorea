<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class DeleteManyProductRequest extends FormRequest {
	final public function rules(): array {
		return [
			"ids" => "required|array",
			"ids.*" => "numeric",
		];
	}
}
