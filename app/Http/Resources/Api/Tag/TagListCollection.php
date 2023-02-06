<?php

namespace App\Http\Resources\Api\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Tag */
class TagListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray($request): array {
		$this->collection->transform(static function (Tag $tag) {
			return new TagResource($tag);
		});

		return parent::toArray($request);
	}
}
