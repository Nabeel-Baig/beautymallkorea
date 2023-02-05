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
		$brandCount = 0;
		$timestamp = Carbon::now()->toDateTimeString();

		foreach ($countries as $countryIndex => $country) {
			$numOfBrandsToGenerateForThisCountry = random_int(1, 6);
			$countryIdentifier = str_pad($countryIndex, 3, "0", STR_PAD_LEFT);

			$serializedCountry = json_encode($country, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

			for ($index = 1; $index <= $numOfBrandsToGenerateForThisCountry; $index++) {
				$identifier = str_pad($index, 4, "0", STR_PAD_LEFT);

				$brands[] = [
					"name" => "Brand $countryIdentifier - $identifier",
					"slug" => Str::slug("Brand $countryIdentifier - $identifier"),
					"country" => $serializedCountry,
					"brand_image" => "images/brand.png",
					"sort_order" => $brandCount++,
					"created_at" => $timestamp,
					"updated_at" => $timestamp,
				];
			}
		}

		Brand::insert($brands);
	}
}
