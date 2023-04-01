<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTagsTable extends Migration {
	final public function up(): void {
		Schema::create("product_tags", static function (Blueprint $table) {
			$table->id();
			$table->foreignId("tag_id")->constrained("tags")->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId("product_id")->constrained("products")->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("product_tags");
	}
}
