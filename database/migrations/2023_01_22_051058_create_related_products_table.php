<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedProductsTable extends Migration {
	final public function up(): void {
		Schema::create('related_products', static function (Blueprint $table) {
			$table->id();
			$table->foreignId("product_id")->constrained("products")->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId("related_product_id")->constrained("products")->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	final public function down(): void {
		Schema::dropIfExists('related_products');
	}
}
