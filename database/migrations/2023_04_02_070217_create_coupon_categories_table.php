<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCategoriesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("coupon_categories", static function (Blueprint $table) {
			$table->id();
			$table->foreignId("coupon_id")->constrained("coupons")->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId("category_id")->constrained("categories")->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	final public function down(): void {
		Schema::dropIfExists("coupon_categories");
	}
}
