<?php

namespace App\Casts;

use App\ValueObjects\AddressValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use JsonException;

class OrderAddress implements CastsAttributes {
	/**
	 * @throws JsonException
	 */
	final public function get(mixed $model, string $key, mixed $value, array $attributes): AddressValueObject {
		$decodedValue = $value !== null ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;

		$addressValueObject = new AddressValueObject();
		$addressValueObject->setAddressLineOne($decodedValue["addressLineOne"] ?? "");
		$addressValueObject->setAddressLineTwo($decodedValue["addressLineTwo"] ?? "");
		$addressValueObject->setAddressCity($decodedValue["addressCity"] ?? "");
		$addressValueObject->setAddressState($decodedValue["addressState"] ?? "");
		$addressValueObject->setAddressCountry($decodedValue["addressCountry"] ?? "");
		$addressValueObject->setAddressZipCode($decodedValue["addressZipCode"] ?? "");

		return $addressValueObject;
	}

	/**
	 * @throws JsonException
	 */
	final public function set(mixed $model, string $key, mixed $value, array $attributes): string {
		if (!$value instanceof AddressValueObject) {
			throw new InvalidArgumentException("The given value is not an AddressValueObject instance.");
		}

		return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}
}
