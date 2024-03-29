<?php
/** @noinspection SpellCheckingInspection */

namespace Database\Seeders;

use App\Enums\DimensionClass;
use App\Enums\ProductOptionUnitAdjustment;
use App\Enums\ProductPromotion;
use App\Enums\ProductShipping;
use App\Enums\ProductStockBehaviour;
use App\Enums\WeightClass;
use App\Models\Brand;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOption;
use App\Models\ProductTag;
use App\Models\RelatedProduct;
use App\Models\Tag;
use App\ValueObjects\ProductDimensionValueObject;
use App\ValueObjects\ProductMetaValueObject;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder {
	/**
	 * @throws Exception
	 */
	final public function run(): void {
		[$products, $productTags, $productOptions, $productCategories, $productRelatedProducts] = [[], [], [], [], []];

		$tags = Tag::all();
		$brands = Brand::all();
		$categories = Category::all();
		$optionValues = OptionValue::all();

		$timestamp = Carbon::now()->toDateTimeString();
		$productCountToGenerate = 500;

		for ($index = 1; $index <= $productCountToGenerate; $index++) {
			$products[] = $this->generateProduct($brands, $index, $timestamp);

			$productTags = [...$productTags, ...$this->generateProductTags($tags, $index, $timestamp)];

			$productOptions = [...$productOptions, ...$this->generateProductOptions($optionValues, $index, $timestamp)];

			$productCategories = [...$productCategories, ...$this->generateProductCategories($categories, $index, $timestamp)];

			$productRelatedProducts = [...$productRelatedProducts, ...$this->generateProductRelatedProducts($productCountToGenerate, $index, $timestamp)];
		}

		$this->insertProductAndRelatedDataInChunks($products, $productTags, $productOptions, $productCategories, $productRelatedProducts);
	}

	/**
	 * @throws Exception
	 */
	private function generateProduct(Collection $brands, int $productId, string $timestamp): array {
		$identifier = str_pad($productId, 3, "0", STR_PAD_LEFT);

		$price = random_int(50 * 100, 2500 * 100) / 100;
		$hasDiscountPrice = random_int(0, 1) === 1;
		$discountPrice = $hasDiscountPrice ? random_int(25 * 100, $price * 100) / 100 : null;

		$productDimensionValueObject = new ProductDimensionValueObject();
		$productDimensionValueObject->setDimensionLength(random_int(0 * 100, 5 * 100) / 100);
		$productDimensionValueObject->setDimensionWidth(random_int(0 * 100, 5 * 100) / 100);
		$productDimensionValueObject->setDimensionHeight(random_int(0 * 100, 5 * 100) / 100);

		$productMetaValueObject = new ProductMetaValueObject();
		$productMetaValueObject->setMetaTitle("SEO Title $identifier");
		$productMetaValueObject->setMetaKeywords("SEO Keyword $identifier");
		$productMetaValueObject->setMetaDescription("SEO Description $identifier");

		return [
			"id" => $productId,
			"brand_id" => $brands->random()->id,
			"name" => "Product - $identifier",
			"slug" => Str::slug("Product - $identifier"),
			"description" => "Lorem ipsum dolor sit amet",
			"meta" => json_encode($productMetaValueObject, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
			"sku" => Str::uuid(),
			"upc" => Str::uuid(),
			"price" => $price,
			"discount_price" => $discountPrice,
			"quantity" => random_int(0, 50),
			"dimension" => json_encode($productDimensionValueObject, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
			"dimension_class" => random_int(DimensionClass::INCH->value, DimensionClass::CENTIMETER->value),
			"weight" => random_int(10 * 100, 50 * 100) / 100,
			"weight_class" => random_int(WeightClass::KILOGRAM->value, WeightClass::POUND->value),
			"image" => "images/product.png",
			"secondary_images" => "[]",
			"min_order_quantity" => random_int(1, 3),
			"subtract_stock" => random_int(ProductStockBehaviour::CONSISTENT_STOCK->value, ProductStockBehaviour::SUBTRACT_STOCK->value),
			"require_shipping" => random_int(ProductShipping::SHIPPING_NOT_REQUIRED->value, ProductShipping::SHIPPING_REQUIRED->value),
			"promotion_status" => random_int(ProductPromotion::NOT_IN_PROMOTION->value, ProductPromotion::IN_PROMOTION->value),
			"created_at" => $timestamp,
			"updated_at" => $timestamp,
		];
	}

	/**
	 * @throws Exception
	 */
	private function generateProductTags(Collection $tags, int $productId, string $timestamp): array {
		$tagsForThisProduct = [];
		$numOfTagsForThisProduct = random_int(1, 10);
		$randomTagsForThisProduct = $tags->random($numOfTagsForThisProduct);

		for ($productTagIndex = 0; $productTagIndex < $numOfTagsForThisProduct; $productTagIndex++) {
			$tagsForThisProduct[] = [
				"tag_id" => $randomTagsForThisProduct[$productTagIndex]->id,
				"product_id" => $productId,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		return $tagsForThisProduct;
	}

	/**
	 * @throws Exception
	 */
	private function generateProductOptions(Collection $optionValues, int $productId, string $timestamp): array {
		$optionValuesForThisProduct = [];
		$numOfOptionValuesForThisProduct = random_int(1, 10);
		$randomOptionValuesForThisProduct = $optionValues->random($numOfOptionValuesForThisProduct);

		for ($productOptionValueIndex = 0; $productOptionValueIndex < $numOfOptionValuesForThisProduct; $productOptionValueIndex++) {
			$optionValuesForThisProduct[] = [
				"option_value_id" => $randomOptionValuesForThisProduct[$productOptionValueIndex]->id,
				"product_id" => $productId,
				"quantity" => random_int(1, 100),
				"subtract_stock" => random_int(ProductStockBehaviour::CONSISTENT_STOCK->value, ProductStockBehaviour::SUBTRACT_STOCK->value),
				"weight_difference" => random_int(0 * 100, 5 * 100) / 100,
				"weight_adjustment" => random_int(ProductOptionUnitAdjustment::NEGATIVE->value, ProductOptionUnitAdjustment::POSITIVE->value),
				"price_difference" => random_int(0 * 100, 25 * 100) / 100,
				"price_adjustment" => random_int(ProductOptionUnitAdjustment::NEGATIVE->value, ProductOptionUnitAdjustment::POSITIVE->value),
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		return $optionValuesForThisProduct;
	}

	/**
	 * @throws Exception
	 */
	private function generateProductCategories(Collection $categories, int $productId, string $timestamp): array {
		$categoriesForThisProduct = [];
		$numOfCategoriesForThisProduct = random_int(1, 10);
		$randomCategoriesForThisProduct = $categories->random($numOfCategoriesForThisProduct);

		for ($productCategoryIndex = 0; $productCategoryIndex < $numOfCategoriesForThisProduct; $productCategoryIndex++) {
			$categoriesForThisProduct[] = [
				"product_id" => $productId,
				"category_id" => $randomCategoriesForThisProduct[$productCategoryIndex]->id,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		return $categoriesForThisProduct;
	}

	/**
	 * @throws Exception
	 */
	private function generateProductRelatedProducts(int $productCountToGenerate, int $productId, string $timestamp): array {
		$relatedProductsForThisProduct = [];
		$numOfRelatedProductsForThisProduct = random_int(1, 10);

		for ($relatedProductIndex = 0; $relatedProductIndex < $numOfRelatedProductsForThisProduct; $relatedProductIndex++) {
			$randomRelatedProductId = $productId;

			while ($randomRelatedProductId === $productId) {
				$randomRelatedProductId = random_int(1, $productCountToGenerate);
			}

			$relatedProductsForThisProduct[] = [
				"product_id" => $productId,
				"related_product_id" => $randomRelatedProductId,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		return $relatedProductsForThisProduct;
	}

	private function insertProductAndRelatedDataInChunks(array $products, array $productTags, array $productOptions, array $productCategories, array $productRelatedProducts): void {
		foreach (array_chunk($products, 1000) as $productChunk) {
			Product::insert($productChunk);
		}

		foreach (array_chunk($productTags, 1000) as $productTagChunk) {
			ProductTag::insert($productTagChunk);
		}

		foreach (array_chunk($productOptions, 1000) as $productOptionChunk) {
			ProductOption::insert($productOptionChunk);
		}

		foreach (array_chunk($productCategories, 1000) as $productCategoryChunk) {
			ProductCategory::insert($productCategoryChunk);
		}

		foreach (array_chunk($productRelatedProducts, 1000) as $productRelatedProductChunk) {
			RelatedProduct::insert($productRelatedProductChunk);
		}
	}
}
