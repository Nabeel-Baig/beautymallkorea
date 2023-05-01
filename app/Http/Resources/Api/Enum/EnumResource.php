<?php

namespace App\Http\Resources\Api\Enum;

use BackedEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BackedEnum */
class EnumResource extends JsonResource {
	final public function toArray(Request $request): array {
		return [
			"name" => $this->name,
			"value" => $this->value,
		];
	}
}
