<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest {
	final public function authorize(): bool {
		return true;
	}

	final public function rules(): array {
		return [
			"first_name" => ["required", "string", "max:255"],
			"last_name" => ["required", "string", "max:255"],
			"email" => ["required", "string", "email", "max:255", "unique:customers"],
			"contact" => ["required", "string", "max:255"],
			"profile_picture" => ["nullable", "sometimes", "image"],
			"password" => ["required", "string", "min:6", "confirmed"],
		];
	}
}
