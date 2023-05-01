<?php

namespace App\Http\Requests\Api\Order;

class CreateGuestOrderRequest extends CreateOrderRequest {
	final public function rules(): array {
		return parent::rules();
	}
}
