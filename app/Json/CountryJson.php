<?php

namespace App\Json;

use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Support\Collection;
use JsonException;

class CountryJson {
	private readonly Collection $countries;

	/**
	 * @throws JsonException
	 */
	public function __construct() {
		$this->countries = $this->loadCountriesJson();
	}

	final public function getCountries(): Collection {
		return $this->countries;
	}

	final public function getCountry(string $countryCode): BrandCountryValueObject {
		return $this->countries->first(static function (BrandCountryValueObject $brandCountryValue) use ($countryCode) {
			return $brandCountryValue->countryCode === $countryCode;
		});
	}

	/**
	 * @throws JsonException
	 */
	private function loadCountriesJson(): Collection {
		$countriesJson = file_get_contents(public_path("countries/countries.json"));
		$parsedCountriesJson = json_decode($countriesJson, true, 512, JSON_THROW_ON_ERROR);

		$countries = array_map(static function (array $parsedCountry) {
			return new BrandCountryValueObject($parsedCountry["countryName"], $parsedCountry["countryCode"], $parsedCountry["countryFlag"]);
		}, $parsedCountriesJson);

		return collect($countries);
	}
}
