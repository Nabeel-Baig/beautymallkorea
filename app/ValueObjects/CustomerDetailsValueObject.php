<?php

namespace App\ValueObjects;

use App\Extensions\ValueObjectExtensions;
use JsonSerializable;

class CustomerDetailsValueObject implements JsonSerializable {
	use ValueObjectExtensions;

	private string $currentActiveIp;

	final public function getCurrentActiveIp(): string {
		return $this->currentActiveIp;
	}

	final public function setCurrentActiveIp(string $currentActiveIp): void {
		$this->currentActiveIp = $currentActiveIp;
	}

	final public function jsonSerialize(): array {
		return [
			"currentActiveIp" => $this->currentActiveIp,
		];
	}
}
