<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class CreateBannerRequest extends FormRequest {
	final public function rules(): array {
		return [
			"country_id" => "required|exists:countries"
		];
	}
}
