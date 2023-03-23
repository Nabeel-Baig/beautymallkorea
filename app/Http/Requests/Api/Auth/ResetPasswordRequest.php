<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest {
	final public function rules(): array {
		return [
			"token" => ["required", "string"],
			"email" => ["required", "string", "email"],
			"password" => ["required", "string", "min:6", "confirmed"],
		];
	}
}
