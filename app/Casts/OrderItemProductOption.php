<?php

namespace App\Casts;

use App\ValueObjects\OrderItemProductOptionValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonException;

class OrderItemProductOption implements CastsAttributes {
	/**
	 * @throws JsonException
	 */
	final public function get(Model $model, string $key, mixed $value, array $attributes): OrderItemProductOptionValueObject {
		$decodedValue = $value !== null ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;

		$orderItemProductOptionValueObject = new OrderItemProductOptionValueObject();
		$orderItemProductOptionValueObject->setOptionName($decodedValue["optionName"] ?? "");
		$orderItemProductOptionValueObject->setOptionValueName($decodedValue["optionValueName"] ?? "");

		return $orderItemProductOptionValueObject;
	}

	/**
	 * @throws JsonException
	 */
	final public function set(Model $model, string $key, mixed $value, array $attributes): ?string {
		if ($value === null) {
			return null;
		}

		if (!$value instanceof OrderItemProductOptionValueObject) {
			throw new InvalidArgumentException("The given value is not an OrderItemProductOptionValueObject instance.");
		}

		return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}
}
