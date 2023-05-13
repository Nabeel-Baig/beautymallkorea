<?php

namespace App\Http\Requests\Api\Order;

class CreateIdentifiedOrderRequest extends CreateOrderRequest {
	final public function rules(): array {
		return parent::rules();
	}
}
