<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Validation\Rules\RequiredIf;

class CreateIdentifiedOrderRequest extends CreateOrderRequest {
	final public function rules(): array {
		$rules = parent::rules();

		$rules["receiver_details.create_account"] = ["required", "boolean"];
		$rules["receiver_details.billing.email"][] = $this->shouldEmailBeUnique();
		$rules["receiver_details.billing.password"] = [new RequiredIf($this->shouldCreateAccount()), "string", "min:6", "confirmed"];

		return $rules;
	}

	private function shouldCreateAccount(): bool {
		return $this->input("receiver_details.create_account");
	}

	private function shouldEmailBeUnique(): string {
		return $this->shouldCreateAccount() ? "unique:customers" : "";
	}
}
