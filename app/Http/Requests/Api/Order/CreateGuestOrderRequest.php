<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Validation\Rules\RequiredIf;

class CreateGuestOrderRequest extends CreateOrderRequest
{
	final public function rules(): array
	{
		$rules = parent::rules();

		$rules["receiver_details.create_account"] = ["required", "boolean"];
		$rules["receiver_details.billing.email"][] = "unique:customers";
		$rules["receiver_details.billing.password"] = ["nullable", "string", "min:6", "confirmed"];

		return $rules;
	}

	final public function shouldNotCreateAccount(): bool
	{
		return !$this->shouldCreateAccount();
	}

	final public function shouldCreateAccount(): bool
	{
		return $this->input("receiver_details.create_account");
	}
}
