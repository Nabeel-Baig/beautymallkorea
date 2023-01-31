<?php
/** @noinspection SpellCheckingInspection */

namespace Database\Seeders;

use App\Enums\ProductOptionPriceAdjustment;
use App\Enums\RequireShipping;
use App\Enums\SubtractStock;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOption;
use App\Models\ProductTag;
use App\Models\RelatedProduct;
use App\Models\Tag;
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
		$categories = Category::all();
		$optionValues = OptionValue::all();

		$timestamp = Carbon::now()->toDateTimeString();

		for ($index = 1; $index <= 1500; $index++) {
			$products[] = $this->generateProduct($index, $index, $timestamp);

			$productTags = [...$productTags, ...$this->generateProductTags($tags, $index, $timestamp)];

			$productOptions = [...$productOptions, ...$this->generateProductOptions($optionValues, $index, $timestamp)];

			$productCategories = [...$productCategories, ...$this->generateProductCategories($categories, $index, $timestamp)];

			$productRelatedProducts = [...$productRelatedProducts, ...$this->generateProductRelatedProducts($index, $timestamp)];
		}

		$this->insertProductAndRelatedDataInChunks($products, $productTags, $productOptions, $productCategories, $productRelatedProducts);
	}

	/**
	 * @throws Exception
	 */
	private function generateProduct(int $index, int $productId, string $timestamp): array {
		$identifier = str_pad($index, 4, "0", STR_PAD_LEFT);

		return [
			"id" => $productId,
			"name" => "Product - $identifier",
			"slug" => Str::snake("Product - $identifier"),
			"description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto assumenda distinctio ducimus eaque eveniet harum in iure mollitia natus, nostrum perspiciatis qui quod repellendus sapiente soluta tenetur totam ullam. Amet beatae doloremque ipsum laborum magnam modi molestias non praesentium quaerat, quasi! Alias architecto, consectetur deserunt dignissimos distinctio eaque error, hic, iure laboriosam magni nisi quod repellat sint. Animi at, cupiditate ducimus eum facere illum laudantium, maxime minus, molestiae nostrum numquam perspiciatis qui sapiente tempore ut veniam vitae. Ab laboriosam perferendis recusandae voluptate voluptatem? Atque eius facere numquam perspiciatis quaerat quas reprehenderit, sed sit! Amet architecto esse magni molestiae rerum? Ab consectetur distinctio dolores eum exercitationem obcaecati placeat quod rem soluta, velit! Accusamus animi at consectetur dolore dolorum eveniet id ipsa mollitia, praesentium provident reprehenderit sequi ut veniam? Ab adipisci atque commodi cum distinctio dolor doloribus eius fugiat fugit incidunt labore, natus nemo nisi officiis optio perspiciatis quia quod saepe sed tempora tempore temporibus vitae voluptates. Beatae corporis eius et exercitationem id magni nesciunt quaerat qui, quisquam. Accusantium atque eum ex exercitationem fuga fugiat fugit nisi quis? A accusamus adipisci asperiores assumenda at atque blanditiis consectetur consequatur corporis debitis deserunt distinctio esse eum ex excepturi facere fuga id ipsum, magni maiores modi non nulla odio odit pariatur quae quam, quod rem saepe sed soluta unde vel velit veniam vitae voluptas voluptatem. Cumque dolor inventore placeat saepe similique? Amet aperiam architecto aspernatur beatae cupiditate, dolor dolorem ducimus ex facere facilis fugit in molestias pariatur perferendis praesentium quam quibusdam rerum sapiente sed ullam!",
			"meta_title" => "SEO Title $identifier",
			"meta_description" => "SEO Description $identifier",
			"meta_keywords" => "SEO Keyword $identifier",
			"sku" => Str::uuid(),
			"upc" => Str::uuid(),
			"price" => random_int(50, 2500),
			"quantity" => random_int(0, 50),
			"image" => null,
			"secondary_images" => "[]",
			"min_order_quantity" => random_int(1, 3),
			"subtract_stock" => random_int(SubtractStock::NO->value, SubtractStock::YES->value),
			"require_shipping" => random_int(RequireShipping::NO->value, RequireShipping::YES->value),
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
				"subtract_stock" => random_int(SubtractStock::NO->value, SubtractStock::YES->value),
				"price_difference" => random_int(0, 50),
				"price_adjustment" => random_int(ProductOptionPriceAdjustment::NEGATIVE->value, ProductOptionPriceAdjustment::POSITIVE->value),
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
	private function generateProductRelatedProducts(int $productId, string $timestamp): array {
		$relatedProductsForThisProduct = [];
		$numOfRelatedProductsForThisProduct = random_int(1, 10);

		for ($relatedProductIndex = 0; $relatedProductIndex < $numOfRelatedProductsForThisProduct; $relatedProductIndex++) {
			$randomRelatedProductId = $productId;

			while ($randomRelatedProductId === $productId) {
				$randomRelatedProductId = random_int(1, 1500);
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
