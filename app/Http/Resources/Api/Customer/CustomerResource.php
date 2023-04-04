<?php

namespace App\Http\Resources\Api\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CustomerResource extends JsonResource {
	final public function toArray(Request $request): array {
		return [
			"first_name" => $this->first_name,
			"last_name" => $this->last_name,
			"profile_picture" => $this->profile_picture,
			"email" => $this->email,
			"contact" => $this->contact,
		];
	}
}
