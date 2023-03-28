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

		$brandCountryValueObject = new BrandCountryValueObject();
		$brandCountryValueObject->setCountryName($decodedValue["countryName"] ?? "");
		$brandCountryValueObject->setCountryCode($decodedValue["countryCode"] ?? "");
		$brandCountryValueObject->setCountryFlag($decodedValue["countryFlag"] ?? "");

		return $brandCountryValueObject;
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
