<?php

namespace App\ValueObjects;

use JsonSerializable;

class BrandCountryValueObject implements JsonSerializable {
	public function __construct(public readonly string $countryName, public readonly string $countryCode, public readonly string $countryFlag) {}

	final public function jsonSerialize(): array {
		return [
			"countryName" => $this->countryName,
			"countryCode" => $this->countryCode,
			"countryFlag" => $this->countryFlag,
		];
	}
}
