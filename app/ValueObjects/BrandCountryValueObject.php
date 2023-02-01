<?php

namespace App\ValueObjects;

use JsonException;
use JsonSerializable;

class BrandCountryValueObject implements JsonSerializable {
	public function __construct(public readonly string $countryName, public readonly string $countryCode, public readonly string $countryFlag) {}

	/**
	 * @throws JsonException
	 */
	final public function jsonSerialize(): string {
		return json_encode([
			"countryName" => $this->countryName,
			"countryCode" => $this->countryCode,
			"countryFlag" => $this->countryFlag,
		], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
	}
}
