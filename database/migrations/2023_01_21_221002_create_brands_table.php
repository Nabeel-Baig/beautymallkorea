<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("brands", static function (Blueprint $table) {
			$table->id();
			$table->string("name")->unique();
			$table->string("slug")->unique();
			$table->text("country");
			$table->string("brand_image");
			$table->string("brand_banner_image");
			$table->integer("sort_order");
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
		Schema::dropIfExists("brands");
	}
}
