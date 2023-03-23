<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest {
	final public function rules(): array {
		return [
			"email" => ["required", "string", "email"],
		];
	}
}
