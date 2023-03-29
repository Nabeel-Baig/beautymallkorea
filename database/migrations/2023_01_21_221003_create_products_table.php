<?php

use App\Enums\DimensionClass;
use App\Enums\ProductPromotion;
use App\Enums\ProductShipping;
use App\Enums\ProductStockBehaviour;
use App\Enums\WeightClass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
	final public function up(): void {
		Schema::create("products", static function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->nullable()->constrained("brands")->nullOnDelete();
			$table->string("name")->unique();
			$table->string("slug")->unique();
			$table->longText("description")->nullable();
			$table->text("meta");
			$table->string("sku")->unique();
			$table->string("upc")->unique();
			$table->decimal("price");
			$table->decimal("discount_price")->nullable();
			$table->unsignedInteger("quantity");
			$table->string("dimension");
			$table->unsignedTinyInteger("dimension_class")->default(DimensionClass::INCH->value);
			$table->unsignedDecimal("weight")->default(0.00);
			$table->unsignedTinyInteger("weight_class")->default(WeightClass::KILOGRAM->value);
			$table->string("image");
			$table->text("secondary_images");
			$table->unsignedInteger("min_order_quantity")->default(1);
			$table->boolean("subtract_stock")->default(ProductStockBehaviour::SUBTRACT_STOCK->value);
			$table->boolean("require_shipping")->default(ProductShipping::SHIPPING_REQUIRED->value);
			$table->boolean("promotion_status")->default(ProductPromotion::NOT_IN_PROMOTION->value);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("products");
	}
}
