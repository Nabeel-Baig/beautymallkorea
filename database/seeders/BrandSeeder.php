<?php

namespace Database\Seeders;

use App\Models\Brand;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JsonException;

class BrandSeeder extends Seeder {
	/**
	 * @throws JsonException
	 * @throws Exception
	 */
	final public function run(): void {
		$countriesJson = file_get_contents(public_path("countries/countries.json"));
		$countries = collect(json_decode($countriesJson, true, 512, JSON_THROW_ON_ERROR));

		$brands = [];
		$timestamp = Carbon::now()->toDateTimeString();

		foreach ($countries as $countryIndex => $country) {
			$numOfBrandsToGenerateForThisCountry = random_int(1, 6);
			$countryIdentifier = str_pad($countryIndex, 3, "0", STR_PAD_LEFT);

			for ($index = 1; $index <= $numOfBrandsToGenerateForThisCountry; $index++) {
				$identifier = str_pad($index, 4, "0", STR_PAD_LEFT);

				$brands[] = [
					"name" => "Brand $countryIdentifier - $identifier",
					"slug" => Str::slug("Brand $countryIdentifier - $identifier"),
					"country" => $country["country-name"],
					"country_image" => "countries/images/{$country["country-code"]}.svg",
					"brand_image" => null,
					"sort_order" => $index,
					"created_at" => $timestamp,
					"updated_at" => $timestamp,
				];
			}
		}

		Brand::insert($brands);
	}
}
