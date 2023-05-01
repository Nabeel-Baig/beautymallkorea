<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Order\OrderListCollection;
use App\Http\Resources\Api\Order\OrderResource;
use App\Services\Api\OrderApiService;

class OrderController extends Controller {
	public function __construct(private readonly OrderApiService $orderApiService) {}

	final public function index(): OrderListCollection {
		$orderList = $this->orderApiService->index();

		return new OrderListCollection($orderList);
	}

	final public function guestCheckout(): OrderResource {
		$order = null;

		return new OrderResource($order);
	}

	final public function identifiedCheckout(): OrderResource {
		$order = null;

		return new OrderResource($order);
	}
}
