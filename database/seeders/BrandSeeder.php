<?php

namespace Database\Seeders;

use App\Models\Brand;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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

		foreach ($countries as $country) {
			$numOfBrandsToGenerateForThisCountry = random_int(1, 6);

			for ($index = 1; $index <= $numOfBrandsToGenerateForThisCountry; $index++) {
				$identifier = str_pad($index, 4, "0", STR_PAD_LEFT);

				$brands[] = [
					"name" => "Brand $identifier",
					"country" => $country["country-name"],
					"image" => asset("countries/images/{$country["country-code"]}.svg"),
					"sort_order" => $index,
					"created_at" => $timestamp,
					"updated_at" => $timestamp,
				];
			}
		}


		Brand::insert($brands);
	}
}
