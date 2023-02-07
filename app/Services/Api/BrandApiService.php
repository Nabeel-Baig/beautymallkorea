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
		$brandListBuilder = $this->createBrandListBuilder($brandListRequest);

		return $brandListBuilder->orderBy("sort_order")->paginate()->withQueryString()->onEachSide(1);
	}

	final public function brandProductList(Brand $brand, ProductListRequest $productListRequest): Collection|LengthAwarePaginator {
		$productListBuilder = $this->productApiService->createProductListBuilder($productListRequest);

		$productListBuilder = $this->applySpecificBrandFilter($brand, $productListBuilder);

		return $this->productApiService->buildProductListResult($productListBuilder, $productListRequest);
	}

	private function createBrandListBuilder(BrandListRequest $brandListRequest): Builder {
		$brandListBuilder = $this->createBrandSelection();

		return $this->createBrandFilters($brandListBuilder, $brandListRequest);
	}

	private function createBrandSelection(): Builder {
		return Brand::query()->select(["id", "name", "brand_image", "country", "slug"]);
	}

	private function createBrandFilters(Builder $brandListBuilder, BrandListRequest $brandListRequest): Builder {
		return $this->applyNameFilter($brandListBuilder, $brandListRequest);
	}

	private function applyNameFilter(Builder $brandListBuilder, BrandListRequest $brandListRequest): Builder {
		return $brandListBuilder
			->when($brandListRequest->has("name"), static function (Builder $builder) use ($brandListRequest) {
				return $builder->where("name", "like", "%{$brandListRequest->input("name")}%");
			});
	}

	private function applySpecificBrandFilter(Brand $brand, Builder $productListBuilder): Builder {
		return $productListBuilder->where("brand_id", "=", $brand->id);
	}
}
