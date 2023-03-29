<?php

namespace App\Casts;

use App\ValueObjects\OrderDetailsValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use JsonException;

class OrderDetails implements CastsAttributes {
	/**
	 * @throws JsonException
	 */
	final public function get(mixed $model, string $key, mixed $value, array $attributes): OrderDetailsValueObject {
		$decodedValue = $value !== null ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;

		$orderDetailsValueObject = new OrderDetailsValueObject();
		$orderDetailsValueObject->setIpAddress($decodedValue["ipAddress"] ?? "");
		$orderDetailsValueObject->setUserAgent($decodedValue["userAgent"] ?? "");
		$orderDetailsValueObject->setComment($decodedValue["comment"] ?? "");

		return $orderDetailsValueObject;
	}

	/**
	 * @throws JsonException
	 */
	final public function set(mixed $model, string $key, mixed $value, array $attributes): string {
		if (!$value instanceof OrderDetailsValueObject) {
			throw new InvalidArgumentException("The given value is not an OrderDetailsValueObject instance.");
		}

		return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}
}
