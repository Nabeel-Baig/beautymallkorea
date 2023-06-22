<?php

namespace App\Http\Resources\Api\Wishlist;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Wishlist */
class WishlistListCollection extends ResourceCollection
{
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (Wishlist $wishlist) {
			return new WishlistResource($wishlist);
		});

		return parent::toArray($request);
	}
}
