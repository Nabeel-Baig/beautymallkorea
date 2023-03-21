<?php

namespace App\Http\Requests\Admin\Brand;

use App\Json\CountryJson;
use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest {
	final public function rules(): array {
		$countries = app(CountryJson::class)->getCountries();
		$brand = $this->route("brand");
		$countryCodes = array_map(static fn(BrandCountryValueObject $country) => $country->getCountryCode(), $countries->toArray());

		return [
			"name" => ["required", "string", Rule::unique("brands", "name")->ignore($brand)],
			"country_code" => ["required", Rule::in($countryCodes)],
			"brand_image" => "nullable|image",
			"brand_old_image" => "required|string",
			"brand_banner_image" => "nullable|image",
			"sort_order" => "nullable|numeric",
		];
	}
}
