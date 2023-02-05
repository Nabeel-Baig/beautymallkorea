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
	final public function toArray($request): array {
		return [
			"name" => $this->name,
			"slug" => $this->slug,
			"country_flag" => $this->country->countryFlag,
			"brand_image" => $this->brand_image,
		];
	}
}
