<?php

namespace App\Http\Requests\Admin\Brand;

use App\Services\BrandService;
use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JsonException;

class UpdateBrandRequest extends FormRequest {
	/**
	 * @throws JsonException
	 */
	final public function rules(): array {
		$countries = app(BrandService::class)->prepareCountryList();
		$brand = $this->route("brand");
		$countryCodes = array_map(static fn(BrandCountryValueObject $country) => $country->countryCode, $countries->toArray());

		return [
			"name" => ["required", "string", Rule::unique("brands", "name")->ignore($brand)],
			"country_code" => ["required", Rule::in($countryCodes)],
			"brand_image" => "nullable|image",
			"brand_old_image" => "required|string",
			"sort_order" => "nullable|numeric",
		];
	}
}
