<?php

namespace App\Services\Api;

use App\Enums\ProductOptionUnitAdjustment;
use App\Enums\ProductStockBehaviour;
use App\Enums\ShippingMethod;
use App\Http\Requests\Api\Order\CreateOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOption;
use App\ValueObjects\AddressValueObject;
use App\ValueObjects\OrderDetailsValueObject;
use App\ValueObjects\OrderItemProductOptionValueObject;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;

class OrderProcessingService {
	public function __construct(private readonly ProductApiService $productApiService) {}

	final public function prepareOrder(CreateOrderRequest $createOrderRequest, ?Customer $customer): Order {
		return new Order([
			"customer_id" => $customer?->id,
			...$createOrderRequest->billingDetails(),
			...$createOrderRequest->shippingDetails(),
			"billing_address" => $this->prepareAddressValueObject($createOrderRequest->billingAddress()),
			"shipping_address" => $this->prepareAddressValueObject($createOrderRequest->shippingAddress()),
			"order_details" => $this->prepareOrderDetailsValueObject($createOrderRequest->orderDetails()),
			"shipping_method" => $createOrderRequest->input("order_details.shipping_method"),
			"payment_method" => $createOrderRequest->input("order_details.payment_method"),
		]);
	}

	final public function prepareOrderItems(CreateOrderRequest $createOrderRequest): Collection {
		$currentTimeStamp = Carbon::now()->toDateTimeString();
		$orderItemRequest = $createOrderRequest->orderItems();
		$productSlugs = $orderItemRequest->map(static fn(array $orderItem) => $orderItem["slug"]);
		$products = $this->productApiService->fetchProductsForOrderCreation($productSlugs->toArray());

		return $orderItemRequest->map(function (array $orderItem) use ($currentTimeStamp, $products) {
			$orderItemOptionId = $orderItem["option_id"] ?? null;

			$orderItemProduct = $this->selectProductFromOrderedProducts($products, $orderItem["slug"]);
			$orderItemProductOption = $orderItemOptionId ? $this->selectProductOptionFromOrderedProducts($orderItemProduct, $orderItemOptionId) : null;
			$orderItemProductOptionName = $orderItemProductOption ? $this->prepareOrderItemProductOptionName($orderItemProductOption) : null;
			$orderItemWeight = $this->calculateOrderItemWeight($orderItemProduct, $orderItemProductOption);
			$orderItemQuantity = $this->verifyAndSubtractOrderItemQuantityFromStock($orderItemProduct, $orderItemProductOption, $orderItem["quantity"]);
			$orderItemPrice = $this->calculateOrderItemPrice($orderItemProduct, $orderItemProductOption);

			return [
				"product_id" => $orderItemProduct->id,
				"product_option_id" => $orderItemProductOption?->id,
				"product_name" => $orderItemProduct->name,
				"product_option_name" => $orderItemProductOptionName?->convertToJson(),
				"product_quantity" => $orderItemQuantity,
				"product_weight" => $orderItemWeight,
				"product_weight_class" => $orderItemProduct->weight_class,
				"product_dimension" => $orderItemProduct->dimension->convertToJson(),
				"product_dimension_class" => $orderItemProduct->dimension_class,
				"product_image" => $orderItemProductOption->optionValue->image ?? $orderItemProduct->image,
				"product_price" => $orderItemPrice,
				"product_total_price" => $orderItemQuantity * $orderItemPrice,
				"created_at" => $currentTimeStamp,
				"updated_at" => $currentTimeStamp,
			];
		});
	}

	final public function setOrderPrices(CreateOrderRequest $createOrderRequest, Order $order, Collection $orderItems): Order {
		$shippingMethod = $createOrderRequest->input("order_details.shipping_method");

		$order->actual_amount = $orderItems->reduce(static fn(float $total, array $orderItem) => $total + $orderItem["product_total_price"], 0.00);
		$order->discount_amount = 0.00;
		$order->shipping_amount = $shippingMethod === ShippingMethod::FREE_SHIPPING ? 0.00 : 25.00;

		return $order;
	}

	final public function associateOrderItemsWithOrder(Order $order, Collection $orderItems): Collection {
		return $orderItems->map(static function (array $orderItem) use ($order) {
			$orderItem["order_id"] = $order->id;

			return $orderItem;
		});
	}

	private function prepareAddressValueObject(array $addressData): AddressValueObject {
		$address = new AddressValueObject();
		$address->setAddressLineOne($addressData["address_line_one"]);
		$address->setAddressLineTwo($addressData["address_line_two"] ?? "");
		$address->setAddressCity($addressData["address_city"]);
		$address->setAddressState($addressData["address_state"]);
		$address->setAddressCountry($addressData["address_country"]);
		$address->setAddressZipCode($addressData["address_zip_code"]);

		return $address;
	}

	private function prepareOrderDetailsValueObject(array $orderDetailsData): OrderDetailsValueObject {
		$orderDetails = new OrderDetailsValueObject();
		$orderDetails->setComment($orderDetailsData["comment"] ?? "");
		$orderDetails->setIpAddress($orderDetailsData["requestIp"]);
		$orderDetails->setUserAgent($orderDetailsData["userAgent"]);

		return $orderDetails;
	}

	private function verifyAndSubtractOrderItemQuantityFromStock(Product $product, ?ProductOption $productOption, int $orderedQuantity): int {
		$orderItemModel = $productOption ?? $product;

		if ($orderItemModel->quantity >= $orderedQuantity) {
			if ($orderItemModel->subtract_stock === ProductStockBehaviour::SUBTRACT_STOCK) {
				$orderItemModel->update(["quantity" => $orderItemModel->quantity -= $orderedQuantity]);
			}

			return $orderedQuantity;
		}

		throw new BadRequestException("Invalid order quantity");
	}

	private function calculateOrderItemWeight(Product $product, ?ProductOption $productOption): float {
		if (!$productOption) {
			return $product->weight;
		}

		return $productOption->weight_adjustment === ProductOptionUnitAdjustment::POSITIVE ? $product->weight + $productOption->weight_difference : $product->weight - $productOption->weight_difference;
	}

	private function calculateOrderItemPrice(Product $product, ?ProductOption $productOption): float {
		$productPrice = $product->discount_price ? $product->price - $product->discount_price : $product->price;
		if (!$productOption) {
			return $productPrice;
		}

		return $productOption->price_adjustment === ProductOptionUnitAdjustment::POSITIVE ? $productPrice + $productOption->price_difference : $productPrice - $productOption->price_difference;
	}

	private function selectProductFromOrderedProducts(Collection $products, string $productSlug): Product {
		$orderItemProduct = $products->firstWhere("slug", "=", $productSlug);
		if ($orderItemProduct instanceof Product) {
			return $orderItemProduct;
		}

		throw new BadRequestException("Invalid product slug: $productSlug", Response::HTTP_BAD_REQUEST);
	}

	private function selectProductOptionFromOrderedProducts(Product $product, int $productOptionId): ProductOption {
		$orderItemProductOption = $product->productOptions->firstWhere("id", "=", $productOptionId);
		if ($orderItemProductOption instanceof ProductOption) {
			return $orderItemProductOption;
		}

		throw new BadRequestException("Invalid product option id: $productOptionId", Response::HTTP_BAD_REQUEST);
	}

	private function prepareOrderItemProductOptionName(ProductOption $productOption): OrderItemProductOptionValueObject {
		$orderItemProductOptionName = new OrderItemProductOptionValueObject();
		$orderItemProductOptionName->setOptionName($productOption->optionValue->option->name);
		$orderItemProductOptionName->setOptionValueName($productOption->optionValue->name);

		return $orderItemProductOptionName;
	}
}
