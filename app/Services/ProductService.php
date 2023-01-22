<?php

namespace App\Services;

use App\Http\Requests\Product\ManageProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService {
	final public function fetchProductDataForManagement(Product $product): Product {
		$product->load([
			"relatedProducts" => static function (BelongsToMany $query) {
				return $query->select(["products.id", "products.name"]);
			},
			"tags" => static function (BelongsToMany $query) {
				return $query->select(["tags.id", "tags.name"]);
			},
			"categories" => static function (BelongsToMany $query) {
				return $query->select(["categories.id", "categories.name"]);
			},
			"options" => static function (BelongsToMany $query) {
				return $query->select(["option_values.id", "option_values.name", "option_id", "option_values.image"])->with([
					"option" => static function (BelongsTo $query) {
						return $query->select(["options.id", "options.name"]);
					},
				]);
			},
		]);

		return $product;
	}

	final public function getProductsForDropdown(): Collection {
		return Product::select(["id", "name"])->get();
	}

	final public function manage(ManageProductRequest $manageProductRequest, Product $product = null): void {
		DB::transaction(function () use ($product, $manageProductRequest) {
			$data = $manageProductRequest->validated();

			$product = $this->manageProductsBasicData($product, $data["product"]);

			$this->manageProductOptionsData($product, $data["options"]);

			$this->manageProductTagsData($product, $data["tags"]);

			$this->manageProductCategoriesData($product, $data["categories"]);

			$this->manageRelatedProductsData($product, $data["related_products"]);
		});
	}

	private function manageProductsBasicData(Product|null $product, array $productData): Product {
		if (!Arr::exists($productData, "image") || $productData["image"] === null) {
			$productData["image"] = $productData["old_image"] ?? null;
		}

		unset($productData["old_image"]);

		$productData = handleFiles("products", $productData);

		if ($product === null) {
			$productData["slug"] = Str::slug($productData["name"]);
			$product = Product::create($productData);
		} else {
			$product->update($productData);
		}

		return $product;
	}

	private function manageProductOptionsData(Product $product, array|null $productOptionsData): void {
		if ($productOptionsData === null) {
			return;
		}

		$synchronizedData = [];

		foreach ($productOptionsData as $optionData) {
			$filteredOptionData = array_filter($optionData, static function ($optionDataValue) {
				return $optionDataValue !== null;
			});

			$optionValueId = $filteredOptionData["option_value_id"];
			unset($filteredOptionData["option_value_id"]);

			$synchronizedData[$optionValueId] = $filteredOptionData;
		}

		$product->options()->sync($synchronizedData);
	}

	private function manageProductTagsData(Product $product, array|null $productTags): void {
		if ($productTags === null) {
			return;
		}

		$product->tags()->sync($productTags);
	}

	private function manageProductCategoriesData(Product $product, array|null $productCategories): void {
		if ($productCategories === null) {
			return;
		}

		$product->categories()->sync($productCategories);
	}

	private function manageRelatedProductsData(Product $product, array|null $relatedProducts): void {
		if ($relatedProducts === null) {
			return;
		}

		$product->relatedProducts()->sync($relatedProducts);
	}
}
