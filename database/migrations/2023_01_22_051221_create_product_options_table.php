<?php

use App\Enums\ProductOptionUnitAdjustment;
use App\Enums\ProductStockBehaviour;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration {
	final public function up(): void {
		Schema::create("product_options", static function (Blueprint $table) {
			$table->id();
			$table->foreignId("product_id")->constrained("products")->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId("option_value_id")->constrained("option_values")->cascadeOnUpdate()->cascadeOnDelete();
			$table->unsignedInteger("quantity");
			$table->boolean("subtract_stock")->default(ProductStockBehaviour::SUBTRACT_STOCK->value);
			$table->unsignedDecimal("weight_difference")->default(0.00);
			$table->boolean("weight_adjustment")->default(ProductOptionUnitAdjustment::POSITIVE->value);
			$table->unsignedDecimal("price_difference")->default(0.00);
			$table->boolean("price_adjustment")->default(ProductOptionUnitAdjustment::POSITIVE->value);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("product_options");
	}
}
