<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
	final public function authorize(): bool {
		return true;
	}

	final public function rules(): array {
		return [
			"first_name" => ["required", "string", "max:255"],
			"last_name" => ["required", "string", "max:255"],
			"email" => ["required", "string", "email", "max:255"],
			"password" => ["required", "string", "min:6", "confirmed"],
			"profile_picture" => ["nullable", "sometimes", "image"],
			"contact" => ["required", "string", "max:255"],
		];
	}
}
