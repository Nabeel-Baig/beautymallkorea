<?php

namespace App\Http\Requests\Admin\Brand;

use App\Json\CountryJson;
use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBrandRequest extends FormRequest {
	final public function rules(): array {
		$countries = app(CountryJson::class)->getCountries();
		$countryCodes = array_map(static fn(BrandCountryValueObject $country) => $country->getCountryCode(), $countries->toArray());

		return [
			"name" => ["required", "string", Rule::unique("brands", "name")],
			"country_code" => ["required", Rule::in($countryCodes)],
			"brand_image" => "required|image",
			"sort_order" => "nullable|numeric",
			"brand_banner_image" => "required|image",
		];
	}
}
