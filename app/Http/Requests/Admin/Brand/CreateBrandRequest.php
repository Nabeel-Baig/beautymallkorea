<?php

namespace App\Http\Requests\Admin\Brand;

use App\Services\BrandService;
use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JsonException;

class CreateBrandRequest extends FormRequest {
	/**
	 * @throws JsonException
	 */
	final public function rules(): array {
		$countries = app(BrandService::class)->prepareCountryList();
		$countryCodes = array_map(static fn(BrandCountryValueObject $country) => $country->countryCode, $countries->toArray());

		return [
			"name" => ["required", "string", Rule::unique("brands", "name")],
			"country_code" => ["required", Rule::in($countryCodes)],
			"brand_image" => "required|image",
			"sort_order" => "nullable|numeric",
		];
	}
}
