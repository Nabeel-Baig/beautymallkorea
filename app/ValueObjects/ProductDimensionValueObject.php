<?php

namespace App\ValueObjects;

use JsonSerializable;

class ProductDimensionValueObject implements JsonSerializable {
	private float $dimensionLength;
	private float $dimensionWidth;
	private float $dimensionHeight;

	final public function getDimensionLength(): float {
		return $this->dimensionLength;
	}

	final public function setDimensionLength(float $dimensionLength): void {
		$this->dimensionLength = $dimensionLength;
	}

	final public function getDimensionWidth(): float {
		return $this->dimensionWidth;
	}

	final public function setDimensionWidth(float $dimensionWidth): void {
		$this->dimensionWidth = $dimensionWidth;
	}

	final public function getDimensionHeight(): float {
		return $this->dimensionHeight;
	}

	final public function setDimensionHeight(float $dimensionHeight): void {
		$this->dimensionHeight = $dimensionHeight;
	}

	final public function jsonSerialize(): array {
		return [
			"dimensionLength" => $this->dimensionLength,
			"dimensionWidth" => $this->dimensionWidth,
			"dimensionHeight" => $this->dimensionHeight,
		];
	}
}
