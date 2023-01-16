<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class DeleteManyCurrencyRequest extends FormRequest {
	final public function rules(): array {
		return [
			"ids" => "array",
			"ids.*" => "numeric",
		];
	}
}
