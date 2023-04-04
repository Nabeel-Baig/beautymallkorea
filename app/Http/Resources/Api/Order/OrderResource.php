<?php

namespace App\Http\Resources\Api\Order;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\ShippingMethod;
use App\Http\Resources\Api\OrderItem\OrderItemListCollection;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Order */
class OrderResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"first_name" => $this->first_name,
			"last_name" => $this->last_name,
			"email" => $this->email,
			"contact" => $this->contact,
			"shipping_first_name" => $this->shipping_first_name,
			"shipping_last_name" => $this->shipping_last_name,
			"shipping_email" => $this->shipping_email,
			"shipping_contact" => $this->shipping_contact,
			"billing_address" => $this->billing_address,
			"shipping_address" => $this->shipping_address,
			"order_comment" => $this->order_details->getComment(),
			"order_status" => OrderStatus::formattedName($this->order_status),
			"payment_method" => PaymentMethod::formattedName($this->payment_method),
			"shipping_method" => ShippingMethod::formattedName($this->shipping_method),
			"actual_amount" => $this->actual_amount,
			"discount_amount" => $this->discount_amount,
			"shipping_amount" => $this->shipping_amount,
			"total_amount" => $this->total_amount,

			"orderItems" => new OrderItemListCollection($this->whenLoaded("orderItems")),
		];
	}
}
