<?php

namespace App\Http\Resources\Api\Product;

use App\Models\OptionValue;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OptionValue */
class OptionValueResource extends JsonResource {
	final public function toArray($request): array {
		return [
			"name" => $this->name,
			"image" => $this->image,

			"option" => new OptionResource($this->whenLoaded("option")),
		];
	}
}
