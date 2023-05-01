<?php

namespace App\Http\Requests\Api\Order;

use App\Enums\PaymentMethod;
use App\Enums\ShippingMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateOrderRequest extends FormRequest {
	/** @noinspection MethodShouldBeFinalInspection */
	public function rules(): array {
		return [
			// Order Items
			"order_items" => ["array", "required"],

			"order_items.*.slug" => ["required", "string"],
			"order_items.*.quantity" => ["required", "numeric"],
			"order_items.*.option_id" => ["nullable", "numeric"],
			// ==============================================================================================

			// Receiver Details
			"receiver_details" => ["required", "array"],

			// Receiver Billing Details
			"receiver_details.billing" => ["required", "array"],

			"receiver_details.billing.first_name" => ["required", "string", "max:255"],
			"receiver_details.billing.last_name" => ["required", "string", "max:255"],
			"receiver_details.billing.email" => ["required", "string", "email", "max:255"],
			"receiver_details.billing.contact" => ["required", "string", "max:255"],

			// Receiver Shipping Details
			"receiver_details.shipping" => ["required", "array"],

			"receiver_details.shipping.first_name" => ["required", "string", "max:255"],
			"receiver_details.shipping.last_name" => ["required", "string", "max:255"],
			"receiver_details.shipping.email" => ["required", "string", "email", "max:255"],
			"receiver_details.shipping.contact" => ["required", "string", "max:255"],
			// ==============================================================================================

			// Address Details
			"address_details" => ["required", "array"],

			// Address Billing Details
			"address_details.billing" => ["required", "array"],

			"address_details.billing.address_line_one" => ["required", "array"],
			"address_details.billing.address_line_two" => ["nullable", "array"],
			"address_details.billing.address_city" => ["required", "array"],
			"address_details.billing.address_state" => ["required", "array"],
			"address_details.billing.address_country" => ["required", "array"],
			"address_details.billing.address_zip_code" => ["required", "array"],

			// Address Shipping Details
			"address_details.shipping" => ["required", "array"],

			"address_details.shipping.address_line_one" => ["required", "array"],
			"address_details.shipping.address_line_two" => ["nullable", "array"],
			"address_details.shipping.address_city" => ["required", "array"],
			"address_details.shipping.address_state" => ["required", "array"],
			"address_details.shipping.address_country" => ["required", "array"],
			"address_details.shipping.address_zip_code" => ["required", "array"],
			// ==============================================================================================

			// Order Details
			"order_details" => ["required", "array"],

			"order_details.comment" => ["nullable", "string"],
			"order_details.shipping_method" => ["required", new Enum(ShippingMethod::class)],
			"order_details.payment_method" => ["required", new Enum(PaymentMethod::class)],
			// ==============================================================================================
		];
	}
}
