<?php

namespace App\ValueObjects;

use JsonSerializable;

class AddressValueObject implements JsonSerializable {
	private string $address_line_one;
	private string $address_line_two;
	private string $address_city;
	private string $address_state;
	private string $address_country;
	private string $address_zip_code;

	final public function getAddressLineOne(): string {
		return $this->address_line_one;
	}

	final public function setAddressLineOne(string $address_line_one): void {
		$this->address_line_one = $address_line_one;
	}

	final public function getAddressLineTwo(): string {
		return $this->address_line_two;
	}

	final public function setAddressLineTwo(string $address_line_two): void {
		$this->address_line_two = $address_line_two;
	}

	final public function getAddressCity(): string {
		return $this->address_city;
	}

	final public function setAddressCity(string $address_city): void {
		$this->address_city = $address_city;
	}

	final public function getAddressState(): string {
		return $this->address_state;
	}

	final public function setAddressState(string $address_state): void {
		$this->address_state = $address_state;
	}

	final public function getAddressCountry(): string {
		return $this->address_country;
	}

	final public function setAddressCountry(string $address_country): void {
		$this->address_country = $address_country;
	}

	final public function getAddressZipCode(): string {
		return $this->address_zip_code;
	}

	final public function setAddressZipCode(string $address_zip_code): void {
		$this->address_zip_code = $address_zip_code;
	}

	final public function jsonSerialize(): array {
		return [
			"addressLineOne" => $this->address_line_one,
			"addressLineTwo" => $this->address_line_two,
			"addressCity" => $this->address_city,
			"addressState" => $this->address_state,
			"addressCountry" => $this->address_country,
			"addressZipCode" => $this->address_zip_code,
		];
	}
}
