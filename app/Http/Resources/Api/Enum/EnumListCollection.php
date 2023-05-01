<?php

namespace App\Http\Resources\Api\Enum;

use BackedEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see BackedEnum */
class EnumListCollection extends ResourceCollection {
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (BackedEnum $backedEnum) {
			return new EnumResource($backedEnum);
		});

		return parent::toArray($request);
	}
}
