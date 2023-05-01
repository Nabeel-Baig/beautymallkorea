<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentMethod;
use App\Enums\ShippingMethod;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Enum\EnumListCollection;

class OrderProcessingMethodController extends Controller {
	final public function paymentMethod(): EnumListCollection {
		$paymentMethods = PaymentMethod::cases();

		return new EnumListCollection($paymentMethods);
	}

	final public function shippingMethod(): EnumListCollection {
		$shippingMethods = ShippingMethod::cases();

		return new EnumListCollection($shippingMethods);
	}
}
