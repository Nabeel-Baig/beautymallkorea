<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Product\AddProductToWishlistRequest;
use App\Http\Requests\Api\Product\ProductListQueryParamsRequest;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductApiService {
	final public function __construct(private readonly AuthApiService $authApiService) {}

	final public function productList(ProductListQueryParamsRequest $productListQueryParamsRequest): Collection|LengthAwarePaginator {
		$productListBuilder = $this->createProductListBuilder($productListQueryParamsRequest);

		return $this->buildProductListResult($productListBuilder, $productListQueryParamsRequest);
	}

	final public function productDetails(Product $product): Product {
		$optionColumnSelection = ["options.id", "options.name"];
		$optionValueColumnSelection = ["option_values.id", "option_values.name", "option_values.option_id", "option_values.image"];
		$productOptionColumnSelection = ["product_options.id", "product_options.product_id", "product_options.option_value_id", "product_options.quantity", "product_options.subtract_stock", "product_options.price_difference", "product_options.price_adjustment"];
		$categoryColumnSelection = ["categories.id", "categories.name", "categories.slug", "categories.description", "categories.image"];
		$tagColumnSelection = ["tags.id", "tags.slug", "tags.name"];
		$brandColumnSelection = ["brands.id", "brands.name", "brands.slug", "brands.brand_image", "brands.country"];
		$relatedProductColumnSelection = ["products.id", "products.brand_id", "products.name", "products.slug", "products.price", "products.discount_price", "products.image"];

		$optionSelection = static fn(BelongsTo $option) => $option->select($optionColumnSelection);
		$optionValueSelection = static fn(BelongsTo $optionValue) => $optionValue->select($optionValueColumnSelection)->with(["option" => $optionSelection]);
		$productOptionSelection = static fn(HasMany $productOption) => $productOption->select($productOptionColumnSelection)->with(["optionValue" => $optionValueSelection]);
		$categorySelection = static fn(BelongsToMany $category) => $category->select($categoryColumnSelection);
		$tagSelection = static fn(BelongsToMany $tag) => $tag->select($tagColumnSelection);
		$brandSelection = static fn(BelongsTo $brand) => $brand->select($brandColumnSelection);
		$relatedProductSelection = static fn(BelongsToMany $relatedProduct) => $relatedProduct->select($relatedProductColumnSelection)->with(["brand" => $brandSelection]);

		return $product->load(["relatedProducts" => $relatedProductSelection, "brand" => $brandSelection, "tags" => $tagSelection, "categories" => $categorySelection, "productOptions" => $productOptionSelection]);
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

	final public function fetchProductsForOrderCreation(array $productSlugs): Collection {
		$optionColumnSelection = ["id", "name"];
		$optionValueColumnSelection = ["id", "name", "option_id", "image"];
		$productOptionColumnSelection = ["id", "product_id", "option_value_id", "price_difference", "price_adjustment", "weight_difference", "weight_adjustment", "quantity", "subtract_stock"];
		$productColumnSelection = ["id", "name", "slug", "image", "dimension", "dimension_class", "weight", "weight_class", "quantity", "subtract_stock", "price", "discount_price"];

		$optionSelection = static fn(BelongsTo $option) => $option->select($optionColumnSelection);
		$optionValueSelection = static fn(BelongsTo $optionValue) => $optionValue->with(["option" => $optionSelection])->select($optionValueColumnSelection);
		$productOptionSelection = static fn(HasMany $productOption) => $productOption->with(["optionValue" => $optionValueSelection])->select($productOptionColumnSelection);
		return Product::with(["productOptions" => $productOptionSelection])->select($productColumnSelection)->whereIn("slug", $productSlugs)->get();
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

	final public function addToWishlist(AddProductToWishlistRequest $wishlistRequest): Wishlist {
		$data = $wishlistRequest->validated();
		$customer = $this->authApiService->getAuthenticatedCustomer();

		if ($wishlistRequest->input("product_option_id") !== null) {
			$itemToAddInCart = ProductOption::whereId($data["product_option_id"])->whereProductId($data["product_id"])->select(["id", "product_id"])->firstOrFail();
		} else {
			$itemToAddInCart = Product::whereId($data["product_id"])->select(["id"])->firstOrFail();
		}

		if ($itemToAddInCart instanceof ProductOption) {
			return Wishlist::create([
				"customer_id" => $customer->id,
				"product_id" => $itemToAddInCart->product_id,
				"product_option_id" => $itemToAddInCart->id,
			]);
		}

		return Wishlist::create([
			"customer_id" => $customer->id,
			"product_id" => $itemToAddInCart->id,
		]);
	}
}
