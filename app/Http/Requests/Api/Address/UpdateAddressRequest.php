<?php

namespace App\Http\Requests\Api\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest {
	final public function rules(): array {
		return [
			"is_default" => ["nullable", "boolean"],
			"address_line_one" => ["nullable", "string"],
			"address_line_two" => ["nullable", "string"],
			"address_city" => ["nullable", "string"],
			"address_state" => ["nullable", "string"],
			"address_country" => ["nullable", "string"],
			"address_zip_code" => ["nullable", "string"],
		];
	}
}
