<?php

namespace App\Services;

use App\Http\Requests\Admin\Brand\CreateBrandRequest;
use App\Http\Requests\Admin\Brand\DeleteManyBrandRequest;
use App\Http\Requests\Admin\Brand\UpdateBrandRequest;
use App\Models\Brand;
use App\ValueObjects\BrandCountryValueObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use JsonException;

class BrandService {
	final public function paginate(): JsonResponse {
		return response()->json();
	}

	final public function getBrandsForDropdown(): Collection {
		return Brand::select(["id", "name", "country"])->get();
	}

	/**
	 * @throws JsonException
	 */
	final public function prepareCountryList(): Collection {
		$countriesJson = file_get_contents(public_path("countries/countries.json"));
		$parsedCountriesJson = json_decode($countriesJson, true, 512, JSON_THROW_ON_ERROR);
		$countries = [];

		foreach ($parsedCountriesJson as $parsedCountry) {
			$countries[] = new BrandCountryValueObject($parsedCountry["countryName"], $parsedCountry["countryCode"], $parsedCountry["countryFlag"]);
		}

		return collect($countries);
	}

	/**
	 * @throws JsonException
	 */
	final public function create(CreateBrandRequest $createBrandRequest): Brand {
		$data = $createBrandRequest->validated();

		$data = handleFiles("brands", $data);

		$data = $this->calculateBrandSortOrder($data);

		$data["country"] = $this->findCountryByCountryCode($data["country_code"]);
		unset($data["country_code"]);

		return Brand::create($data);
	}

	/**
	 * @throws JsonException
	 */
	final public function update(Brand $brand, UpdateBrandRequest $updateBrandRequest): Brand {
		$data = $updateBrandRequest->validated();

		if (!Arr::exists($data, "brand_image") || $data["brand_image"] === null) {
			$data["brand_image"] = $data["brand_old_image"] ?? null;
		} else {
			$data = handleFilesIfPresent("brands", $data, $brand);
		}

		unset($data["brand_old_image"]);

		$data = $this->calculateBrandSortOrder($data);

		$data["country"] = $this->findCountryByCountryCode($data["country_code"]);
		unset($data["country_code"]);

		$brand->update($data);
		return $brand;
	}

	final public function delete(Brand $brand): void {
		$brand->delete();
	}

	final public function deleteMany(DeleteManyBrandRequest $deleteManyBrandRequest): void {
		$ids = $deleteManyBrandRequest->input("ids");

		Brand::whereIn("id", $ids)->delete();
	}

	/**
	 * @throws JsonException
	 */
	private function findCountryByCountryCode(string $countryCode): BrandCountryValueObject {
		return $this->prepareCountryList()->first(static function (BrandCountryValueObject $brandCountryValue) use ($countryCode) {
			return $brandCountryValue->countryCode === $countryCode;
		});
	}

	private function calculateBrandSortOrder(array $data): array {
		if (!Arr::exists($data, "sort_order") || $data["sort_order"] === null) {
			$latestBrand = Brand::latest("sort_order")->first(["sort_order"]);
			$data["sort_order"] = $latestBrand === null ? 0 : $latestBrand->sort_order + 1;
		}

		return $data;
	}
}
