<?php

namespace App\Http\Requests\Admin\Tag;

use Illuminate\Foundation\Http\FormRequest;

class DeleteManyTagsRequest extends FormRequest {
	final public function rules(): array {
		return [
			"ids" => "array",
			"ids.*" => "numeric",
		];
	}
}
