<?php

namespace App\Http\Resources\Api\OrderItem;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see OrderItem */
class OrderItemListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (OrderItem $orderItem) {
			return new OrderItemResource($orderItem);
		});

		return parent::toArray($request);
	}
}
