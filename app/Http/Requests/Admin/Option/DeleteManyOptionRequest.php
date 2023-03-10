<?php

namespace App\Http\Requests\Admin\Option;

use Illuminate\Foundation\Http\FormRequest;

class DeleteManyOptionRequest extends FormRequest {
	final public function rules(): array {
		return [
			"ids" => "required|array",
			"ids.*" => "numeric",
		];
	}
}
