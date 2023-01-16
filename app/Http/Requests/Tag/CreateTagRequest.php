<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class CreateTagRequest extends FormRequest {
	final public function rules(): array {
		return [
			"name" => "required|string|max:191|min:3",
		];
	}
}
