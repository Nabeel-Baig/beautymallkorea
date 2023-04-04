<?php

namespace App\Http\Resources\Api\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Order */
class OrderListCollection extends ResourceCollection {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		$this->collection->transform(static function (Order $order) {
			return new OrderResource($order);
		});

		return parent::toArray($request);
	}
}
