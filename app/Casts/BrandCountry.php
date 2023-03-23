<?php

namespace App\Casts;

use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use JsonException;

class BrandCountry implements CastsAttributes {
	/**
	 * @throws JsonException
	 */
	final public function get(mixed $model, string $key, mixed $value, array $attributes): BrandCountryValueObject {
		$decodedValue = $value !== null ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;

		$brandValueObject = new BrandCountryValueObject();
		$brandValueObject->setCountryName($decodedValue["countryName"] ?? "");
		$brandValueObject->setCountryCode($decodedValue["countryCode"] ?? "");
		$brandValueObject->setCountryFlag($decodedValue["countryFlag"] ?? "");

		return $brandValueObject;
	}

	/**
	 * @throws JsonException
	 */
	final public function set(mixed $model, string $key, mixed $value, array $attributes): string {
		if (!$value instanceof BrandCountryValueObject) {
			throw new InvalidArgumentException("The given value is not an BrandCountryValueObject instance.");
		}

		return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}
}
