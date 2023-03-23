<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest {
	final public function rules(): array {
		return [
			"password" => ["required", "string", "min:6", "confirmed"],
		];
	}
}
