<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Product\ProductListRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryApiService {
	public function __construct(private readonly ProductApiService $productApiService) {}

	final public function categoriesList(): Collection {
		$categoryListBuilder = $this->createCategorySelection();

		$categoryListBuilder = $this->createCategoryRelationships($categoryListBuilder);

		return $categoryListBuilder->orderBy("sort_order")->get();
	}

	final public function categoryProductList(Category $category, ProductListRequest $productListRequest): Collection|LengthAwarePaginator {
		$productListBuilder = $this->productApiService->createProductListBuilder($productListRequest);

		$productListBuilder = $this->applySpecificCategoryFilter($category, $productListBuilder);

		return $this->productApiService->buildProductListResult($productListBuilder, $productListRequest);
	}

	private function createCategorySelection(): Builder {
		return Category::query()->select(["id", "category_id", "name", "description", "slug", "image"]);
	}

	private function createCategoryRelationships(Builder $categoryListBuilder): Builder {
		return $categoryListBuilder->whereNull("category_id")->with("childrenCategories:id,category_id,name,description,slug,image");
	}

	private function applySpecificCategoryFilter(Category $category, Builder $productListBuilder): Builder {
		$categoryIdCollection = $category->flattenedChildrenCategories()->map(static fn(Category $category) => $category->id);

		return $productListBuilder->whereHas("categories", static function (Builder $categoryQuery) use ($categoryIdCollection) {
			$categoryQuery->whereIn("categories.id", $categoryIdCollection->toArray());
		});
	}
}
