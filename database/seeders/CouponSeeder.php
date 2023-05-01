<?php

namespace Database\Seeders;

use App\Enums\CouponType;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponProduct;
use App\Models\Product;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CouponSeeder extends Seeder {
	/**
	 * @throws Exception
	 */
	final public function run(): void {
		$coupons = [];
		$couponProducts = [];
		$couponCategories = [];
		$products = $this->fetchEntity(Product::class);
		$categories = $this->fetchEntity(Category::class);
		$timestamp = Carbon::now()->toDateTimeString();

		for ($couponId = 1; $couponId <= 300; $couponId++) {
			$coupons[] = $this->prepareCouponData($couponId, $timestamp);
			$couponProducts = [...$couponProducts, ...$this->prepareCouponRelatedData($couponId, $products, "product_id", $timestamp)];
			$couponCategories = [...$couponCategories, ...$this->prepareCouponRelatedData($couponId, $categories, "category_id", $timestamp)];
		}

		Coupon::insert($coupons);
		CouponProduct::insert($couponProducts);
		CouponCategory::insert($couponCategories);
	}

	/**
	 * @throws Exception
	 */
	private function prepareCouponData(int $couponId, string $timestamp): array {
		$couponType = CouponType::random();
		$maxPossibleDiscount = $couponType === CouponType::PERCENTAGE ? 30 : 10;
		$discount = random_int(100, $maxPossibleDiscount * 100) / 100;

		$startDate = Carbon::now();
		$endDate = $startDate->addDays(random_int(1, 30));

		return [
			"id" => $couponId,
			"name" => "Coupon - " . Str::of($couponId)->padLeft(3, "0")->toString(),
			"code" => Str::of(Str::random())->upper()->toString(),
			"type" => $couponType->value,
			"discount" => $discount,
			"date_start" => $startDate->toDateString(),
			"date_end" => $endDate->toDateString(),
			"created_at" => $timestamp,
			"updated_at" => $timestamp,
			"deleted_at" => null,
		];
	}

	/**
	 * @throws Exception
	 */
	private function prepareCouponRelatedData(int $couponId, Collection $entities, string $entityForeignKey, string $timestamp): array {
		$couponRelatedEntities = [];
		$couponShouldIncludeEntities = (bool)random_int(0, 1);
		if (!$couponShouldIncludeEntities) {
			return $couponRelatedEntities;
		}

		foreach ($entities->random(random_int(1, 4)) as $entity) {
			$couponRelatedEntities[] = [
				"coupon_id" => $couponId,
				$entityForeignKey => $entity->id,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		return $couponRelatedEntities;
	}

	private function fetchEntity(string $model): Collection {
		/** @noinspection PhpUndefinedMethodInspection */
		return $model::select(["id"])->get();
	}
}
