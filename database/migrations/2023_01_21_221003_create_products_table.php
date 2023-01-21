<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
	final public function up(): void {
		Schema::create('products', static function (Blueprint $table) {
			$table->id();
			$table->string("name");
			$table->string("slug");
			$table->text("description")->nullable();
			$table->string("meta_title")->nullable();
			$table->string("meta_description")->nullable();
			$table->string("meta_keywords")->nullable();
			$table->string("sku")->unique();
			$table->string("upc")->unique();
			$table->timestamps();
		});
	}

	final public function down(): void {
		Schema::dropIfExists('products');
	}
}
