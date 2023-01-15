<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class CreateCurrencyRequest extends FormRequest {
	final public function rules(): array {
		return [
			"name" => "required|string|max:191|min:3",
			"symbol" => "required|string|max:3",
			"short_name" => "required|string|max:3",
		];
	}
}
