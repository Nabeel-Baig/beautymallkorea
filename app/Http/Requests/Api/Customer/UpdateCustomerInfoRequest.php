<?php

namespace App\Http\Requests\Api\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerInfoRequest extends FormRequest {
	final public function rules(): array {
		return [
			"first_name" => ["nullable", "string", "max:255"],
			"last_name" => ["nullable", "string", "max:255"],
			"profile_picture" => ["nullable", "sometimes", "image"],
			"profile_picture_old" => ["required", "string"],
			"contact" => ["nullable", "string", "max:255"],
		];
	}
}
