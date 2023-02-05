<?php

namespace App\Casts;

use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonException;

class BrandCountry implements CastsAttributes {
	/**
	 * @param Model  $model
	 * @param string $key
	 * @param mixed  $value
	 * @param array  $attributes
	 *
	 * @return BrandCountryValueObject
	 * @throws JsonException
	 */
	final public function get(mixed $model, string $key, mixed $value, array $attributes): BrandCountryValueObject {
		$decodedValue = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

		$countryName = $decodedValue["countryName"];
		$countryCode = $decodedValue["countryCode"];
		$countryFlag = $decodedValue["countryFlag"];

		return new BrandCountryValueObject($countryName, $countryCode, $countryFlag);
	}

	/**
	 * @param Model                   $model
	 * @param string                  $key
	 * @param BrandCountryValueObject $value
	 * @param array                   $attributes
	 *
	 * @return array
	 * @throws JsonException
	 */
	final public function set(mixed $model, string $key, mixed $value, array $attributes): string {
		if (!$value instanceof BrandCountryValueObject) {
			throw new InvalidArgumentException("The given value is not an BrandCountryValueObject instance.");
		}

		return $value->jsonSerialize();
	}
}
