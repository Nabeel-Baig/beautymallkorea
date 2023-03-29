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
		$addressValueObject->setAddressLineOne($addressValueObject["addressLineOne"] ?? "");
		$addressValueObject->setAddressLineTwo($addressValueObject["addressLineTwo"] ?? "");
		$addressValueObject->setAddressCity($addressValueObject["addressCity"] ?? "");
		$addressValueObject->setAddressState($addressValueObject["addressState"] ?? "");
		$addressValueObject->setAddressCountry($addressValueObject["addressCountry"] ?? "");
		$addressValueObject->setAddressZipCode($addressValueObject["addressZipCode"] ?? "");

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
