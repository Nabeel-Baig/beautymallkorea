<?php

namespace App\Http\Resources\Api\Brand;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Brand */
class BrandResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"name" => $this->name,
			"slug" => $this->slug,
			"country_name" => $this->country->getCountryName(),
			"country_code" => $this->country->getCountryCode(),
			"country_flag" => $this->country->getCountryFlag(),
			"brand_image" => $this->brand_image,
			"brand_banner_image" => $this->brand_banner_image,
		];
	}
}
