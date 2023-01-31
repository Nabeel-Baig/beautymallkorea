<?php

use App\Enums\RequireShipping;
use App\Enums\SubtractStock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
	final public function up(): void {
		Schema::create('products', static function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->nullable()->constrained("brands")->nullOnDelete();
			$table->string("name")->unique();
			$table->string("slug")->unique();
			$table->text("description")->nullable();
			$table->string("meta_title")->nullable();
			$table->string("meta_description")->nullable();
			$table->string("meta_keywords")->nullable();
			$table->string("sku")->unique();
			$table->string("upc")->unique();
			$table->unsignedInteger("price");
			$table->unsignedInteger("quantity");
			$table->string("image")->nullable();
			$table->text("secondary_images")->nullable();
			$table->unsignedInteger("min_order_quantity")->default(1);
			$table->boolean("subtract_stock")->default(SubtractStock::YES->value);
			$table->boolean("require_shipping")->default(RequireShipping::YES->value);
			$table->timestamps();
		});
	}

	final public function down(): void {
		Schema::dropIfExists('products');
	}
}
