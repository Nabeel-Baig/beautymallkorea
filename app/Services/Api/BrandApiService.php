<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Brand\BrandListRequest;
use App\Http\Requests\Api\Product\ProductListRequest;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandApiService {
	public function __construct(private readonly ProductApiService $productApiService) {}

	final public function brandsList(BrandListRequest $brandListRequest): LengthAwarePaginator {
		$filteredName = $brandListRequest->input("name");

		return Brand::select(["name", "brand_image", "country", "slug"])
			->when($filteredName !== null, static function (Builder $builder) use ($filteredName) {
				return $builder->where("name", "like", "%$filteredName%");
			})
			->orderBy("sort_order")
			->paginate()
			->appends($brandListRequest->query());
	}

	final public function brandProductList(Brand $brand, ProductListRequest $productListRequest): Collection|LengthAwarePaginator {
		$productListBuilder = $this->productApiService->createProductListBuilder($productListRequest);

		$productListBuilder = $this->applySpecificBrandFilter($brand, $productListBuilder);

		return $this->productApiService->buildProductListResult($productListBuilder, $productListRequest);
	}

	private function applySpecificBrandFilter(Brand $brand, Builder $productListBuilder): Builder {
		return $productListBuilder->where("brand_id", "=", $brand->id);
	}
}
