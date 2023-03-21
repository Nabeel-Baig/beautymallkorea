<?php

namespace App\ValueObjects;

use JsonSerializable;

class AddressValueObject implements JsonSerializable {
	private string $addressLineOne;
	private string $addressLineTwo;
	private string $addressCity;
	private string $addressState;
	private string $addressCountry;
	private string $addressZipCode;

	final public function getAddressLineOne(): string {
		return $this->addressLineOne;
	}

	final public function setAddressLineOne(string $addressLineOne): void {
		$this->addressLineOne = $addressLineOne;
	}

	final public function getAddressLineTwo(): string {
		return $this->addressLineTwo;
	}

	final public function setAddressLineTwo(string $addressLineTwo): void {
		$this->addressLineTwo = $addressLineTwo;
	}

	final public function getAddressCity(): string {
		return $this->addressCity;
	}

	final public function setAddressCity(string $addressCity): void {
		$this->addressCity = $addressCity;
	}

	final public function getAddressState(): string {
		return $this->addressState;
	}

	final public function setAddressState(string $addressState): void {
		$this->addressState = $addressState;
	}

	final public function getAddressCountry(): string {
		return $this->addressCountry;
	}

	final public function setAddressCountry(string $addressCountry): void {
		$this->addressCountry = $addressCountry;
	}

	final public function getAddressZipCode(): string {
		return $this->addressZipCode;
	}

	final public function setAddressZipCode(string $addressZipCode): void {
		$this->addressZipCode = $addressZipCode;
	}

	final public function jsonSerialize(): array {
		return [
			"addressLineOne" => $this->addressLineOne,
			"addressLineTwo" => $this->addressLineTwo,
			"addressCity" => $this->addressCity,
			"addressState" => $this->addressState,
			"addressCountry" => $this->addressCountry,
			"addressZipCode" => $this->addressZipCode,
		];
	}
}
