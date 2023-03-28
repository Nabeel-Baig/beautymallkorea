<?php

namespace App\Casts;

use App\ValueObjects\ProductDimensionValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonException;

class ProductDimension implements CastsAttributes {
	/**
	 * @throws JsonException
	 */
	final public function get(Model $model, string $key, mixed $value, array $attributes): ProductDimensionValueObject {
		$decodedValue = $value !== null ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;

		$productDimensionValueObject = new ProductDimensionValueObject();
		$productDimensionValueObject->setDimensionLength($decodedValue["dimensionLength"] ?? 0.00);
		$productDimensionValueObject->setDimensionWidth($decodedValue["dimensionWidth"] ?? 0.00);
		$productDimensionValueObject->setDimensionHeight($decodedValue["dimensionHeight"] ?? 0.00);

		return $productDimensionValueObject;
	}

	/**
	 * @throws JsonException
	 */
	final public function set(Model $model, string $key, mixed $value, array $attributes): string {
		if (!$value instanceof ProductDimensionValueObject) {
			throw new InvalidArgumentException("The given value is not an ProductDimensionValueObject instance.");
		}

		return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}
}
