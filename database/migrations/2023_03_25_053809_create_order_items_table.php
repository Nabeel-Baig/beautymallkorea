<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("order_items", static function (Blueprint $table) {
			$table->id();

			$table->foreignId("order_id")->constrained("orders")->cascadeOnDelete();
			$table->foreignId("product_id")->nullable()->constrained("products")->nullOnDelete();
			$table->foreignId("product_option_id")->nullable()->constrained("product_options")->nullOnDelete();
			$table->string("product_name");
			$table->string("product_option_name")->nullable();
			$table->unsignedInteger("product_quantity");
			$table->unsignedDecimal("product_weight");
			$table->unsignedTinyInteger("product_weight_class");
			$table->string("product_dimension");
			$table->unsignedTinyInteger("product_dimension_class");
			$table->string("product_image")->nullable();
			$table->decimal("product_price")->default(0.00);
			$table->decimal("product_total_price")->default(0.00);

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	final public function down(): void {
		Schema::dropIfExists("order_items");
	}
}
