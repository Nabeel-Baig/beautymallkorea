<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickCategoriesTable extends Migration {

	final public function up(): void {
		Schema::create("quick_categories", static function (Blueprint $table) {
			$table->id();
			$table->string("name", 32);
			$table->string("image");
			$table->string("link");
			$table->integer("sort_order");
			$table->timestamps();
			$table->softDeletes();
		});
	}


	final public function down(): void {
		Schema::dropIfExists("quick_categories");
	}
}
