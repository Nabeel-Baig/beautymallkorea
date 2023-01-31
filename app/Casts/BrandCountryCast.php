<?php

namespace App\Casts;

use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use JsonException;

class BrandCountryCast implements CastsAttributes {
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
		[$countryName, $countryFlag] = [null, null];

		if ($value === null) {
			return new BrandCountryValueObject($countryName, $countryFlag);
		}

		$decodedValue = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

		$countryName = Arr::exists($decodedValue, "countryName") && $decodedValue["countryName"] ? $decodedValue["countryName"] : null;
		$countryFlag = Arr::exists($decodedValue, "countryFlag") && $decodedValue["countryFlag"] ? $decodedValue["countryFlag"] : null;

		return new BrandCountryValueObject($countryName, $countryFlag);
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

		return json_encode($value, JSON_THROW_ON_ERROR);
	}
}
