<?php

namespace App\Services\Api;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class OrderApiService {
	public function __construct(private readonly AuthApiService $authApiService) {}

	final public function index(): Collection {
		$customer = $this->authApiService->getAuthenticatedCustomer();

		$orderItemsInclusion = static function (HasMany $orderItem) {
			$orderItem
				->select(["order_items.id", "order_id", "product_name", "product_option_name", "product_quantity", "product_weight", "product_weight_class", "product_dimension", "product_dimension_class", "product_image", "product_price", "product_total_price"]);
		};

		$orderInclusion = static function (HasMany $order) use ($orderItemsInclusion) {
			$order
				->with(["orderItems" => $orderItemsInclusion])
				->select(["orders.id", "customer_id", "first_name", "last_name", "email", "contact", "shipping_first_name", "shipping_last_name", "shipping_email", "shipping_contact", "billing_address", "shipping_address", "order_details", "order_status", "payment_method", "shipping_method", "actual_amount", "discount_amount", "shipping_amount", "total_amount"]);
		};

		return $customer->load(["orders" => $orderInclusion])->orders;
	}
}
