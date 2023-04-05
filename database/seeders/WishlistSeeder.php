<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Wishlist;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class WishlistSeeder extends Seeder {
	/**
	 * @throws Exception
	 */
	final public function run(): void {
		$timestamp = Carbon::now()->toDateTimeString();
		$customers = $this->fetchCustomerIds();
		$products = $this->fetchProductIdsWithTheirOptionIds();
		$wishlist = [];

		for ($index = 0; $index < 500; $index++) {
			$randomCustomer = $customers->random();
			$randomProduct = $products->random();

			$productHasOptions = $randomProduct->productOptions->count() > 0;
			$shouldIncludeProductOption = $productHasOptions && random_int(0, 1);
			$randomProductOption = $shouldIncludeProductOption ? $randomProduct->productOptions->random() : null;

			$wishlist[] = [
				"customer_id" => $randomCustomer->id,
				"product_id" => $randomProduct->id,
				"product_option_id" => $randomProductOption?->id,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		Wishlist::insert($wishlist);
	}

	private function fetchCustomerIds(): Collection {
		return Customer::select(["id"])->get();
	}

	private function fetchProductIdsWithTheirOptionIds(): Collection {
		return Product::with([
			"productOptions" => static function (HasMany $productOption) {
				return $productOption->select(["id", "product_id"]);
			},
		])->select(["id"])->get();
	}
}
