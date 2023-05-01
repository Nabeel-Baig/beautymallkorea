<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\ProductOptionUnitAdjustment;
use App\Enums\ShippingMethod;
use App\Models\Address;
use App\Models\Customer;
use App\Models\OptionValue;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductOption;
use App\ValueObjects\AddressValueObject;
use App\ValueObjects\OrderDetailsValueObject;
use App\ValueObjects\OrderItemProductOptionValueObject;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Seeder;
use JsonException;
use stdClass;

class OrderSeeder extends Seeder {
	/**
	 * @throws JsonException
	 * @throws Exception
	 */
	final public function run(): void {
		[$orders, $orderItems] = [[], []];
		$timestamp = Carbon::now()->toDateTimeString();
		$customersWithAddresses = $this->getCustomersWithTheirAddresses();
		$productsWithOptions = $this->getProductsWithTheirProductOptions();

		for ($orderIndex = 1; $orderIndex <= 500; $orderIndex++) {
			$randomCustomer = $customersWithAddresses->random();
			$randomProducts = $productsWithOptions->random(random_int(1, 2));

			$order = $this->generateOrderEntry($orderIndex, $randomCustomer, $timestamp);
			$associatedOrderItems = $this->generateOrderItemEntries($orderIndex, $randomProducts, $timestamp);

			$actualAmount = array_reduce($associatedOrderItems, static function (float $reducedPrice, array $orderItemEntry) {
				return $reducedPrice + $orderItemEntry["product_total_price"];
			}, 0.00);

			$order["actual_amount"] = $actualAmount;
			$order["discount_amount"] = random_int(0 * 100, $actualAmount * 100) / 100;
			$order["total_amount"] = $order["actual_amount"] - $order["discount_amount"] + $order["shipping_amount"];

			$orders[] = $order;
			$orderItems = [...$orderItems, ...$associatedOrderItems];
		}

		Order::insert($orders);
		OrderItem::insert($orderItems);
	}

	/**
	 * @throws JsonException
	 * @throws Exception
	 */
	private function generateOrderEntry(int $orderIndex, Customer $customer, string $timestamp): array {
		return [
			"id" => $orderIndex,
			"customer_id" => $customer->id,

			"first_name" => $customer->first_name,
			"last_name" => $customer->last_name,
			"email" => $customer->email,
			"contact" => $customer->contact,

			"shipping_first_name" => $customer->first_name,
			"shipping_last_name" => $customer->last_name,
			"shipping_email" => $customer->email,
			"shipping_contact" => $customer->contact,

			"billing_address" => $this->generateAddressValueObject($customer->addresses->random()),
			"shipping_address" => $this->generateAddressValueObject($customer->addresses->random()),

			"order_details" => $this->generateOrderDetailsValueObject(),
			"order_status" => OrderStatus::random()->value,
			"payment_method" => PaymentMethod::random()->value,
			"shipping_method" => ShippingMethod::random()->value,

			"actual_amount" => 0.00,
			"discount_amount" => 0.00,
			"shipping_amount" => random_int(0 * 100, 50 * 100) / 100,
			"total_amount" => 0.00,

			"created_at" => $timestamp,
			"updated_at" => $timestamp,
		];
	}

	/**
	 * @throws Exception
	 */
	private function generateOrderItemEntries(int $orderIndex, Collection $products, string $timestamp): array {
		$orderItems = [];

		foreach ($products as $orderItemProduct) {
			assert($orderItemProduct instanceof Product);

			$randomProductOptions = $this->generateProductOptionOrderItemEntries($orderItemProduct);

			foreach ($randomProductOptions as $productOptionOrderItem) {
				$orderItems[] = [
					"order_id" => $orderIndex,
					"product_id" => $orderItemProduct->id,
					"product_option_id" => $productOptionOrderItem->product_option_id,
					"product_name" => $orderItemProduct->name,
					"product_option_name" => $productOptionOrderItem->product_option_name,
					"product_quantity" => $productOptionOrderItem->product_quantity,
					"product_weight" => $productOptionOrderItem->product_weight,
					"product_weight_class" => $orderItemProduct->weight_class->value,
					"product_dimension" => json_encode($orderItemProduct->dimension, JSON_THROW_ON_ERROR),
					"product_dimension_class" => $orderItemProduct->dimension_class->value,
					"product_image" => $productOptionOrderItem->product_image,
					"product_price" => $productOptionOrderItem->product_price,
					"product_total_price" => $productOptionOrderItem->product_price * $productOptionOrderItem->product_quantity,
					"created_at" => $timestamp,
					"updated_at" => $timestamp,
				];
			}
		}

		return $orderItems;
	}

	/**
	 * @throws Exception
	 */
	private function generateProductOptionOrderItemEntries(Product $product): array {
		$productOptionsAsOrderItem = [];

		$productOptions = $product->productOptions;
		$totalProductOptions = $productOptions->count();
		$randomProductOptions = $productOptions->random(random_int(0, $totalProductOptions));

		if ($randomProductOptions->count() === 0) {
			$productOptionOrderItem = $this->generateProductOptionDistinctOrderItemFields($product);

			$productOptionsAsOrderItem[] = $productOptionOrderItem;
		}

		foreach ($randomProductOptions as $productOption) {
			$productOptionOrderItem = $this->generateProductOptionDistinctOrderItemFields($product, $productOption);

			$productOptionsAsOrderItem[] = $productOptionOrderItem;
		}

		return $productOptionsAsOrderItem;
	}

	/**
	 * @throws JsonException
	 * @throws Exception
	 */
	private function generateProductOptionDistinctOrderItemFields(Product $product, ProductOption $productOption = null): stdClass {
		$productOptionOrderItem = new stdClass();
		$productOptionOrderItem->product_option_id = $productOption?->id;
		$productOptionOrderItem->product_option_name = $productOption === null ? null : $this->generateProductOptionOrderItemValueObject($productOption->optionValue);
		$productOptionOrderItem->product_quantity = random_int(1, 10);
		$productOptionOrderItem->product_weight = $this->calculateProductOptionTotalWeight($product, $productOption);
		$productOptionOrderItem->product_image = $productOption->optionValue->image ?? $product->image;
		$productOptionOrderItem->product_price = $this->calculateProductOptionTotalPrice($product, $productOption);

		return $productOptionOrderItem;
	}

	private function calculateProductOptionTotalWeight(Product $product, ProductOption $productOption = null): float {
		if ($productOption === null) {
			return $product->weight;
		}

		if ($productOption->weight_adjustment === ProductOptionUnitAdjustment::POSITIVE) {
			return $product->weight + $productOption->weight_difference;
		}

		return $product->weight - $productOption->weight_difference;
	}

	private function calculateProductOptionTotalPrice(Product $product, ProductOption $productOption = null): float {
		$productPrice = $product->discount_price ?? $product->price;

		if ($productOption === null) {
			return $productPrice;
		}

		if ($productOption->price_adjustment === ProductOptionUnitAdjustment::POSITIVE) {
			return $productPrice + $productOption->price_difference;
		}

		return $productPrice - $productOption->price_difference;
	}

	/**
	 * @throws JsonException
	 */
	private function generateAddressValueObject(Address $address): string {
		$addressValueObject = new AddressValueObject();
		$addressValueObject->setAddressLineOne($address->address_line_one);
		$addressValueObject->setAddressLineTwo($address->address_line_two);
		$addressValueObject->setAddressCity($address->address_city);
		$addressValueObject->setAddressState($address->address_state);
		$addressValueObject->setAddressCountry($address->address_country);
		$addressValueObject->setAddressZipCode($address->address_zip_code);

		return json_encode($addressValueObject, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}

	/**
	 * @throws JsonException
	 */
	private function generateOrderDetailsValueObject(): string {
		$orderDetailsValueObject = new OrderDetailsValueObject();
		$orderDetailsValueObject->setComment(fake()->text);
		$orderDetailsValueObject->setUserAgent(fake()->userAgent);
		$orderDetailsValueObject->setIpAddress(fake()->ipv4);

		return json_encode($orderDetailsValueObject, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}

	/**
	 * @throws JsonException
	 */
	private function generateProductOptionOrderItemValueObject(OptionValue $optionValue): string {
		$orderItemProductOptionValueObject = new OrderItemProductOptionValueObject();
		$orderItemProductOptionValueObject->setOptionName($optionValue->option->name);
		$orderItemProductOptionValueObject->setOptionValueName($optionValue->name);

		return json_encode($orderItemProductOptionValueObject, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}

	private function getCustomersWithTheirAddresses(): Collection {
		$addressSelection = static function (HasMany $address) {
			$address->select(["customer_id", "address_line_one", "address_line_two", "address_city", "address_state", "address_country", "address_zip_code"]);
		};

		return Customer::with(["addresses" => $addressSelection])->select(["id", "first_name", "last_name", "email", "contact"])->get();
	}

	private function getProductsWithTheirProductOptions(): Collection {
		$optionSelection = static function (BelongsTo $option) {
			$option->select(["id", "name"]);
		};

		$optionValueSelection = static function (BelongsTo $optionValue) use ($optionSelection) {
			$optionValue->with(["option" => $optionSelection])->select(["id", "option_id", "name", "image"]);
		};

		$productOptionSelection = static function (HasMany $productOption) use ($optionValueSelection) {
			$productOption->with(["optionValue" => $optionValueSelection])->select(["id", "product_id", "option_value_id", "weight_adjustment", "weight_difference", "price_adjustment", "price_difference"]);
		};

		return Product::with(["productOptions" => $productOptionSelection])->select(["id", "name", "image", "discount_price", "price", "weight", "weight_class", "dimension", "dimension_class"])->get();
	}
}
