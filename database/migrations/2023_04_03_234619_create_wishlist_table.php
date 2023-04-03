<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistTable extends Migration {
	final public function up(): void {
		Schema::create("wishlist", static function (Blueprint $table) {
			$table->id();
			$table->foreignId("customer_id")->constrained("customers")->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId("product_id")->constrained("products")->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId("product_option_id")->constrained("product_options")->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("wishlist");
	}
}
