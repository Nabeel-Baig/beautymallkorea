<?php

namespace App\Services;

use App\Http\Requests\Admin\Brand\CreateBrandRequest;
use App\Http\Requests\Admin\Brand\DeleteManyBrandRequest;
use App\Http\Requests\Admin\Brand\UpdateBrandRequest;
use App\Json\CountryJson;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class BrandService {
	public function __construct(private readonly CountryJson $countryJson) {}

	final public function paginate(): JsonResponse {
		return datatables()->of(Brand::orderBy('id', 'desc')->get())
			->addColumn('selection', function (Brand $brand) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $brand->id . '">';
			})
			->addColumn('countryName', function (Brand $brand) {
				return $brand->country->getCountryName();
			})
			->addColumn('countryFlag', function (Brand $brand) {
				$brandImage = asset($brand->brand_image);
				return "<img width='80' src='$brandImage' alt='{$brand->country->getCountryName()}'>";
			})
			->addColumn('brand_banner_image', function (Brand $brand) {
				$brand_banner_image = asset($brand->brand_banner_image);
				return "<img width='80' src='$brand_banner_image' alt='{$brand->country->getCountryName()}'>";
			})
			->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				if (Gate::allows('brand_edit')) {
					$edit = '<a title="Edit" href="' . route('admin.brands.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows('brand_delete')) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $delete;
			})->rawColumns(['selection', 'countryFlag', 'brand_banner_image', 'actions'])->make(true);
	}

	final public function getBrandsForDropdown(): Collection {
		return Brand::select(["id", "name", "country"])->get();
	}

	final public function create(CreateBrandRequest $createBrandRequest): Brand {
		$data = $createBrandRequest->validated();

		$data = handleFiles("brands", $data);

		$data = $this->calculateBrandSortOrder($data);

		$data["country"] = $this->countryJson->getCountry($data["country_code"]);
		unset($data["country_code"]);

		return Brand::create($data);
	}

	final public function update(Brand $brand, UpdateBrandRequest $updateBrandRequest): Brand {
		$data = $updateBrandRequest->validated();
		if (!Arr::exists($data, "brand_image") || $data["brand_image"] === null) {
			$data["brand_image"] = $data["brand_old_image"] ?? null;
		} else {
			$data = handleFilesIfPresent("brands", $data, $brand);
		}
		if (Arr::exists($data, 'brand_banner_image')) {
			$data = handleFilesIfPresent("brands", $data, $brand);
		}
		unset($data["brand_old_image"]);

		$data = $this->calculateBrandSortOrder($data);

		$data["country"] = $this->countryJson->getCountry($data["country_code"]);
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

	private function calculateBrandSortOrder(array $data): array {
		if (!Arr::exists($data, "sort_order") || $data["sort_order"] === null) {
			$latestBrand = Brand::latest("sort_order")->first(["sort_order"]);
			$data["sort_order"] = $latestBrand === null ? 0 : $latestBrand->sort_order + 1;
		}

		return $data;
	}
}
