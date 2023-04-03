<?php

namespace App\Http\Requests\Api\Address;

use Illuminate\Foundation\Http\FormRequest;

class CreateAddressRequest extends FormRequest {
	final public function rules(): array {
		return [
			"is_default" => ["nullable", "boolean"],
			"address_line_one" => ["required", "string"],
			"address_line_two" => ["nullable", "string"],
			"address_city" => ["required", "string"],
			"address_state" => ["required", "string"],
			"address_country" => ["required", "string"],
			"address_zip_code" => ["required", "string"],
		];
	}
}
