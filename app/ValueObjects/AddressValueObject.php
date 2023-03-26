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

	/**
	 * @return string
	 */
	final public function getAddressLineOne(): string {
		return $this->address_line_one;
	}

	/**
	 * @param string $address_line_one
	 */
	final public function setAddressLineOne(string $address_line_one): void {
		$this->address_line_one = $address_line_one;
	}

	/**
	 * @return string
	 */
	final public function getAddressLineTwo(): string {
		return $this->address_line_two;
	}

	/**
	 * @param string $address_line_two
	 */
	final public function setAddressLineTwo(string $address_line_two): void {
		$this->address_line_two = $address_line_two;
	}

	/**
	 * @return string
	 */
	final public function getAddressCity(): string {
		return $this->address_city;
	}

	/**
	 * @param string $address_city
	 */
	final public function setAddressCity(string $address_city): void {
		$this->address_city = $address_city;
	}

	/**
	 * @return string
	 */
	final public function getAddressState(): string {
		return $this->address_state;
	}

	/**
	 * @param string $address_state
	 */
	final public function setAddressState(string $address_state): void {
		$this->address_state = $address_state;
	}

	/**
	 * @return string
	 */
	final public function getAddressCountry(): string {
		return $this->address_country;
	}

	/**
	 * @param string $address_country
	 */
	final public function setAddressCountry(string $address_country): void {
		$this->address_country = $address_country;
	}

	/**
	 * @return string
	 */
	final public function getAddressZipCode(): string {
		return $this->address_zip_code;
	}

	/**
	 * @param string $address_zip_code
	 */
	final public function setAddressZipCode(string $address_zip_code): void {
		$this->address_zip_code = $address_zip_code;
	}

	final public function jsonSerialize(): array {
		return [
			"address_line_one" => $this->address_line_one,
			"address_line_two" => $this->address_line_two,
			"address_city" => $this->address_city,
			"address_state" => $this->address_state,
			"address_country" => $this->address_country,
			"address_zip_code" => $this->address_zip_code,
		];
	}
}
