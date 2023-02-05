<?php

namespace App\Http\Requests\Admin\Tag;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest {
	final public function rules(): array {
		return [
			"name" => "required|string|min:3|max:191",
		];
	}
}
