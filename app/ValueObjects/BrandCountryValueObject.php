<?php

namespace App\ValueObjects;

use App\Extensions\ValueObjectExtensions;
use JsonSerializable;

class BrandCountryValueObject implements JsonSerializable {
	use ValueObjectExtensions;

	private string $countryName;
	private string $countryCode;
	private string $countryFlag;

	final public function getCountryName(): string {
		return $this->countryName;
	}

	final public function setCountryName(string $countryName): void {
		$this->countryName = $countryName;
	}

	final public function getCountryCode(): string {
		return $this->countryCode;
	}

	final public function setCountryCode(string $countryCode): void {
		$this->countryCode = $countryCode;
	}

	final public function getCountryFlag(): string {
		return $this->countryFlag;
	}

	final public function setCountryFlag(string $countryFlag): void {
		$this->countryFlag = $countryFlag;
	}

	final public function jsonSerialize(): array {
		return [
			"countryName" => $this->countryName,
			"countryCode" => $this->countryCode,
			"countryFlag" => $this->countryFlag,
		];
	}
}
