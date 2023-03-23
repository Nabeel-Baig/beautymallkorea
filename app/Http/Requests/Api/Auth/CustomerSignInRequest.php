<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSignInRequest extends FormRequest {
	final public function rules(): array {
		return [
			"email" => ["required", "string", "email", "max:255"],
			"password" => ["required", "string", "min:6"],
		];
	}
}
