<?php

namespace App\Http\Resources\Api\Product;

use App\Models\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OptionValue */
class OptionValueResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"name" => $this->name,
			"image" => $this->image,

			"option" => new OptionResource($this->whenLoaded("option")),
		];
	}
}
