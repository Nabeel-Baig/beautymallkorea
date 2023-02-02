<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Product\ProductListRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductApiService {
	final public function productList(ProductListRequest $productListRequest): Collection|LengthAwarePaginator {
		$productListBuilder = $this->createProductListBuilder($productListRequest);

		return $this->buildProductListResult($productListBuilder, $productListRequest);
	}

	final public function createProductListBuilder(ProductListRequest $productListRequest): Builder {
		$productListBuilder = $this->createProductSelection();

		return $this->createProductFilters($productListBuilder, $productListRequest);
	}

	final public function buildProductListResult(Builder $productListBuilder, ProductListRequest $productListRequest): Collection|LengthAwarePaginator {
		if ($productListRequest->input("paginate", true)) {
			return $productListBuilder->paginate($productListRequest->input("numOfProducts"))->appends($productListRequest->query());
		}

		return $productListBuilder->when($productListRequest->has("numOfProducts"), static function (Builder $productListBuilder) use ($productListRequest) {
			$productListBuilder->take($productListRequest->input("numOfProducts"));
		})->get();
	}

	private function createProductSelection(): Builder {
		return Product::query()->select(["name", "slug", "image", "price", "discount_price"]);
	}

	private function createProductFilters(Builder $productListBuilder, ProductListRequest $productListRequest): Builder {
		$productListBuilder = $this->applyNameFilter($productListBuilder, $productListRequest);
		$productListBuilder = $this->applyPriceFilter($productListBuilder, $productListRequest);
		$productListBuilder = $this->applySpecialFilter($productListBuilder, $productListRequest);
		$productListBuilder = $this->applyBrandFilter($productListBuilder, $productListRequest);
		return $this->applyCategoryFilter($productListBuilder, $productListRequest);
	}

	private function applyNameFilter(Builder $productListBuilder, ProductListRequest $productListRequest): Builder {
		return $productListBuilder
			->when($productListRequest->has("productName"), static function (Builder $productListBuilder) use ($productListRequest) {
				$productListBuilder->where("name", "like", "%{$productListRequest->input("productName")}%");
			});
	}

	private function applyPriceFilter(Builder $productListBuilder, ProductListRequest $productListRequest): Builder {
		return $productListBuilder
			->when($productListRequest->has("productPriceFrom"), static function (Builder $productListBuilder) use ($productListRequest) {
				$productListBuilder->where("price", ">=", $productListRequest->input("productPriceFrom"));
			})
			->when($productListRequest->has("productPriceTo"), static function (Builder $productListBuilder) use ($productListRequest) {
				$productListBuilder->where("price", "<=", $productListRequest->input("productPriceTo"));
			});
	}

	private function applySpecialFilter(Builder $productListBuilder, ProductListRequest $productListRequest): Builder {
		return $productListBuilder
			->when($productListRequest->has("promotional"), static function (Builder $productListBuilder) use ($productListRequest) {
				$productListBuilder->where("promotion_status", "=", $productListRequest->input("promotional"));
			});
	}

	private function applyBrandFilter(Builder $productListBuilder, ProductListRequest $productListRequest): Builder {
		return $productListBuilder
			->when($productListRequest->has("productOfBrands"), static function (Builder $productListBuilder) use ($productListRequest) {
				$productListBuilder->whereHas("brand", static function (Builder $productListBuilder) use ($productListRequest) {
					$productListBuilder->whereIn("slug", $productListRequest->input("productOfBrands"));
				});
			});
	}

	private function applyCategoryFilter(Builder $productListBuilder, ProductListRequest $productListRequest): Builder {
		return $productListBuilder
			->when($productListRequest->has("productOfCategories"), static function (Builder $productListBuilder) use ($productListRequest) {
				$productListBuilder->whereHas("categories", static function (Builder $productListBuilder) use ($productListRequest) {
					$productListBuilder->whereIn("slug", $productListRequest->input("productOfCategories"));
				});
			});
	}
}
