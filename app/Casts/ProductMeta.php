<?php

namespace App\Casts;

use App\ValueObjects\ProductMetaValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonException;

class ProductMeta implements CastsAttributes {
	/**
	 * @throws JsonException
	 */
	final public function get(Model $model, string $key, mixed $value, array $attributes): ProductMetaValueObject {
		$decodedValue = $value !== null ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;

		$productMetaValueObject = new ProductMetaValueObject();
		$productMetaValueObject->setMetaTitle($decodedValue["metaTitle"]);
		$productMetaValueObject->setMetaKeywords($decodedValue["metaKeywords"]);
		$productMetaValueObject->setMetaDescription($decodedValue["metaDescription"]);

		return $productMetaValueObject;
	}

	/**
	 * @throws JsonException
	 */
	final public function set(Model $model, string $key, mixed $value, array $attributes): string {
		if (!$value instanceof ProductMetaValueObject) {
			throw new InvalidArgumentException("The given value is not an ProductMetaValueObject instance.");
		}

		return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

	}
}
