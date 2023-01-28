<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Product\ManageProductRequest;
use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductService
{

	final public function paginate(): JsonResponse
	{
		return datatables()->of(Product::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('image', function ($data) {
				return '<img width="65" src="' . asset($data->image) . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$view = '';
				$delete = '';
				if (Gate::allows(PermissionEnum::PRODUCT_MANAGE->value)) {
					$edit = '<a title="Edit" href="' . route('admin.products.manage.show', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::PRODUCT_SHOW->value)) {
					$view = '<a title="View" href="' . route('admin.products.manage.view', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::PRODUCT_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
				}
				return $edit . $view . $delete;
			})->rawColumns(['selection', 'actions', 'image'])->make(true);
	}

	final public function fetchProductDataForManagement(Product|null $product): array
	{
		$product?->load([
			"relatedProducts" => static function (BelongsToMany $query) {
				return $query->select(["products.id", "products.name"]);
			},
			"tags" => static function (BelongsToMany $query) {
				return $query->select(["tags.id", "tags.name"]);
			},
			"categories" => static function (BelongsToMany $query) {
				return $query->select(["categories.id", "categories.name"]);
			},
			"optionValues" => static function (BelongsToMany $query) {
				return $query->select(["option_values.id", "option_values.name", "option_values.option_id", "option_values.image"])->with([
					"option" => static function (BelongsTo $query) {
						return $query->select(["options.id", "options.name"]);
					},
				]);
			},
		]);

		$content["model"] = $product;
		$content["assignedTags"] = $product === null ? [] : $product->tags->pluck("id")->toArray();
		$content["assignedCategories"] = $product === null ? [] : $product->categories->pluck("id")->toArray();
		$content["assignedRelatedProducts"] = $product === null ? [] : $product->relatedProducts->pluck("id")->toArray();
		$content["assignedProductOptionValues"] = $product === null ? [] : $product->optionValues->groupBy(static function (OptionValue $optionValue) {
			return $optionValue->option->id;
		});

		return $content;
	}

	final public function getProductsForDropdown(): Collection
	{
		return Product::select(["id", "name"])->get();
	}

	final public function manage(ManageProductRequest $manageProductRequest, Product $product = null): void
	{
		DB::transaction(function () use ($product, $manageProductRequest) {
			$data = $manageProductRequest->validated();

			$product = $this->manageProductsBasicData($product, $data["product"]);

			$this->manageProductOptionsData($product, $data["options"] ?? null);

			$this->manageProductTagsData($product, $data["tags"] ?? null);

			$this->manageProductCategoriesData($product, $data["categories"] ?? null);

			$this->manageRelatedProductsData($product, $data["related_products"] ?? null);
		});
	}

	private function manageProductsBasicData(Product|null $product, array $productData): Product
	{
		if (!Arr::exists($productData, "image") || $productData["image"] === null) {
			$productData["image"] = $productData["old_image"] ?? null;
		}

		unset($productData["old_image"]);
//		dd($productData);

		$productData = handleFiles("products", $productData);

		if ($productData["secondary_images"]) {
			$productData["secondary_images"] = json_encode($productData["secondary_images"]);
		}
		if ($product === null) {
			$productData["slug"] = Str::slug($productData["name"]);
			$product = Product::create($productData);
		} else {
			$product->update($productData);
		}

		return $product;
	}

	private function manageProductOptionsData(Product $product, array|null $productOptionsData): void
	{
		if ($productOptionsData === null) {
			$productOptionsData = [];
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

		$product->optionValues()->sync($synchronizedData);
	}

	private function manageProductTagsData(Product $product, array|null $productTags): void
	{
		if ($productTags === null) {
			$productTags = [];
		}

		$product->tags()->sync($productTags);
	}

	private function manageProductCategoriesData(Product $product, array|null $productCategories): void
	{
		if ($productCategories === null) {
			$productCategories = [];
		}

		$product->categories()->sync($productCategories);
	}

	private function manageRelatedProductsData(Product $product, array|null $relatedProducts): void
	{
		if ($relatedProducts === null) {
			$relatedProducts = [];
		}

		$product->relatedProducts()->sync($relatedProducts);
	}
}
