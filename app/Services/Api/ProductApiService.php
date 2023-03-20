<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Product\ProductListQueryParamsRequest;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductApiService {
	final public function productList(ProductListQueryParamsRequest $productListQueryParamsRequest): Collection|LengthAwarePaginator {
		$productListBuilder = $this->createProductListBuilder($productListQueryParamsRequest);

		return $this->buildProductListResult($productListBuilder, $productListQueryParamsRequest);
	}

	final public function productDetails(Product $product): Product {
		return $product->load([
			"relatedProducts" => static function (BelongsToMany $query) {
				return $query->select(["products.id", "products.brand_id", "products.name", "products.slug", "products.price", "products.discount_price", "products.image"])->with([
					"brand" => static function (BelongsTo $query) {
						return $query->select(["brands.id", "brands.name", "brands.slug", "brands.brand_image", "brands.country"]);
					},
				]);
			},
			"brand" => static function (BelongsTo $query): BelongsTo {
				return $query->select(["brands.id", "brands.name", "brands.slug", "brands.brand_image", "brands.country"]);
			},
			"tags" => static function (BelongsToMany $query) {
				return $query->select(["tags.id", "tags.slug", "tags.name"]);
			},
			"categories" => static function (BelongsToMany $query) {
				return $query->select(["categories.id", "categories.name", "categories.slug", "categories.description", "categories.image"]);
			},
			"productOptions" => static function (HasMany $query) {
				return $query->select(["product_options.id", "product_options.product_id", "product_options.option_value_id", "product_options.quantity", "product_options.subtract_stock", "product_options.price_difference", "product_options.price_adjustment"])->with([
					"optionValue" => static function (BelongsTo $query) {
						return $query->select(["option_values.id", "option_values.name", "option_values.option_id", "option_values.image"])->with([
							"option" => static function (BelongsTo $query) {
								return $query->select(["options.id", "options.name"]);
							},
						]);
					},
				]);
			},
		]);
	}

	final public function createProductListBuilder(ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		$productListBuilder = $this->createProductSelection();
		$productListBuilder = $this->addProductRelationships($productListBuilder, $productListQueryParamsRequest);

		return $this->createProductFilters($productListBuilder, $productListQueryParamsRequest);
	}

	final public function buildProductListResult(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Collection|LengthAwarePaginator {
		$productListBuilder->when($productListQueryParamsRequest->has("latest"), static function (Builder $productListBuilder) {
			$productListBuilder->latest();
		});

		if ($productListQueryParamsRequest->input("paginate", true)) {
			return $productListBuilder->paginate($productListQueryParamsRequest->input("numOfProducts", 16))->withQueryString()->onEachSide(1);
		}

		return $productListBuilder->when($productListQueryParamsRequest->has("numOfProducts"), static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
			$productListBuilder->take($productListQueryParamsRequest->input("numOfProducts"));
		})->get();
	}

	private function createProductSelection(): Builder {
		return Product::query()->select(["id", "brand_id", "name", "slug", "image", "price", "discount_price"]);
	}

	private function addProductRelationships(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		$withRelationships = $productListQueryParamsRequest->input("with");

		if ($withRelationships === null) {
			return $productListBuilder;
		}

		return $productListBuilder->with($withRelationships);
	}

	private function createProductFilters(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		$productListBuilder = $this->applyNameFilter($productListBuilder, $productListQueryParamsRequest);
		$productListBuilder = $this->applyPriceFilter($productListBuilder, $productListQueryParamsRequest);
		$productListBuilder = $this->applySpecialFilter($productListBuilder, $productListQueryParamsRequest);
		$productListBuilder = $this->applyBrandFilter($productListBuilder, $productListQueryParamsRequest);
		return $this->applyCategoryFilter($productListBuilder, $productListQueryParamsRequest);
	}

	private function applyNameFilter(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		return $productListBuilder
			->when($productListQueryParamsRequest->has("productName"), static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
				$productListBuilder->where("name", "like", "%{$productListQueryParamsRequest->input("productName")}%");
			});
	}

	private function applyPriceFilter(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		return $productListBuilder
			->when($productListQueryParamsRequest->has("productPriceFrom"), static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
				$productListBuilder->where("price", ">=", $productListQueryParamsRequest->input("productPriceFrom"));
			})
			->when($productListQueryParamsRequest->has("productPriceTo"), static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
				$productListBuilder->where("price", "<=", $productListQueryParamsRequest->input("productPriceTo"));
			});
	}

	private function applySpecialFilter(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		return $productListBuilder
			->when($productListQueryParamsRequest->has("promotional"), static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
				$productListBuilder->where("promotion_status", "=", $productListQueryParamsRequest->input("promotional"));
			});
	}

	private function applyBrandFilter(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		return $productListBuilder
			->when($productListQueryParamsRequest->has("productOfBrands"), static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
				$productListBuilder->whereHas("brand", static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
					$productListBuilder->whereIn("slug", $productListQueryParamsRequest->input("productOfBrands"));
				});
			});
	}

	private function applyCategoryFilter(Builder $productListBuilder, ProductListQueryParamsRequest $productListQueryParamsRequest): Builder {
		return $productListBuilder
			->when($productListQueryParamsRequest->has("productOfCategories"), static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
				$productListBuilder->whereHas("categories", static function (Builder $productListBuilder) use ($productListQueryParamsRequest) {
					$productListBuilder->whereIn("slug", $productListQueryParamsRequest->input("productOfCategories"));
				});
			});
	}

	final public function tagProductList(Tag $tag, ProductListQueryParamsRequest $productListQueryParamsRequest): Collection|LengthAwarePaginator
	{
		$productListBuilder = $this->createProductListBuilder($productListQueryParamsRequest);
		$productListBuilder = $this->applySpecificTagFilter($tag, $productListBuilder);

		return $this->buildProductListResult($productListBuilder, $productListQueryParamsRequest);
	}

	final public function applySpecificTagFilter(Tag $tag, Builder $productListBuilder): Builder
	{
		return $productListBuilder->whereHas('tags', static function (Builder $tagQuery) use ($tag) {
			$tagQuery->where('tags.slug', '=', $tag->slug);
		});
	}
}
