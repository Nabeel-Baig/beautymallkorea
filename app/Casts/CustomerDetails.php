<?php

namespace App\Casts;

use App\ValueObjects\CustomerDetailsValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use JsonException;

class CustomerDetails implements CastsAttributes {
	/**
	 * @throws JsonException
	 */
	final public function get(mixed $model, string $key, mixed $value, array $attributes): CustomerDetailsValueObject {
		$decodedValue = $value !== null ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;

		$customerValueObject = new CustomerDetailsValueObject();
		$customerValueObject->setCurrentActiveIp($decodedValue["currentActiveIp"] ?? "");

		return $customerValueObject;
	}

	/**
	 * @throws JsonException
	 */
	final public function set(mixed $model, string $key, mixed $value, array $attributes): string {
		if (!$value instanceof CustomerDetailsValueObject) {
			throw new InvalidArgumentException("The given value is not an CustomerDetailsValueObject instance.");
		}

		return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}
}
