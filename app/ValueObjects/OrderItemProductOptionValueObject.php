<?php

namespace App\ValueObjects;

use App\Extensions\ValueObjectExtensions;
use JsonSerializable;

class OrderItemProductOptionValueObject implements JsonSerializable {
	use ValueObjectExtensions;

	private string $optionName;
	private string $optionValueName;

	final public function getOptionName(): string {
		return $this->optionName;
	}

	final public function setOptionName(string $optionName): void {
		$this->optionName = $optionName;
	}

	final public function getOptionValueName(): string {
		return $this->optionValueName;
	}

	final public function setOptionValueName(string $optionValueName): void {
		$this->optionValueName = $optionValueName;
	}

	final public function isEmpty(): bool {
		return $this->optionName === "" && $this->optionValueName === "";
	}

	final public function jsonSerialize(): array {
		return [
			"optionName" => $this->optionName,
			"optionValueName" => $this->optionValueName,
		];
	}
}
