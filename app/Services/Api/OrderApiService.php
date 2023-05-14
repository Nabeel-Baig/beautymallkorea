<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Order\CreateGuestOrderRequest;
use App\Http\Requests\Api\Order\CreateIdentifiedOrderRequest;
use App\Http\Requests\Api\Order\CreateOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderApiService {
	public function __construct(private readonly AuthApiService $authApiService, private readonly OrderProcessingService $orderProcessingService) {}

	final public function index(): Collection {
		$customer = $this->authApiService->getAuthenticatedCustomer();

		$orderItemsColumnSelection = ["id", "order_id", "product_name", "product_option_name", "product_quantity", "product_weight", "product_weight_class", "product_dimension", "product_dimension_class", "product_image", "product_price", "product_total_price"];
		$orderColumnSelection = ["id", "customer_id", "first_name", "last_name", "email", "contact", "shipping_first_name", "shipping_last_name", "shipping_email", "shipping_contact", "billing_address", "shipping_address", "order_details", "order_status", "payment_method", "shipping_method", "actual_amount", "discount_amount", "shipping_amount", "total_amount"];

		$orderItemsInclusion = static fn(HasMany $orderItem) => $orderItem->select($orderItemsColumnSelection);
		$orderInclusion = static fn(HasMany $order) => $order->with(["orderItems" => $orderItemsInclusion])->select($orderColumnSelection);
		return $customer->load(["orders" => $orderInclusion])->orders;
	}

	final public function guestCheckout(CreateGuestOrderRequest $createGuestOrderRequest): Order {
		return DB::transaction(function () use ($createGuestOrderRequest) {
			$customer = $this->createCustomerIfRequired($createGuestOrderRequest);

			return $this->createOrder($createGuestOrderRequest, $customer);
		});
	}

	final public function identifiedCheckout(CreateIdentifiedOrderRequest $createIdentifiedOrderRequest): Order {
		return DB::transaction(function () use ($createIdentifiedOrderRequest) {
			$customer = $this->authApiService->getAuthenticatedCustomer();

			return $this->createOrder($createIdentifiedOrderRequest, $customer);
		});
	}

	private function createOrder(CreateOrderRequest $createOrderRequest, ?Customer $customer): Order {
		$order = $this->orderProcessingService->prepareOrder($createOrderRequest, $customer);
		$orderItems = $this->orderProcessingService->prepareOrderItems($createOrderRequest);
		$order = $this->orderProcessingService->setOrderPrices($createOrderRequest, $order, $orderItems);

		$order->save();
		$orderItems = $this->orderProcessingService->associateOrderItemsWithOrder($order, $orderItems);
		$order->orderItems()->insert($orderItems->toArray());

		return $order;
	}

	private function createCustomerIfRequired(CreateGuestOrderRequest $createGuestOrderRequest): ?Customer {
		if ($createGuestOrderRequest->shouldNotCreateAccount()) {
			return null;
		}

		return $this->authApiService->createNewCustomer($createGuestOrderRequest->billingDetails());
	}
}
