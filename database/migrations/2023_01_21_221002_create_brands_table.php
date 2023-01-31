<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	final public function up(): void {
		Schema::create("brands", static function (Blueprint $table) {
			$table->id();
			$table->string("name");
			$table->string("country");
			$table->string("country_image");
			$table->string("brand_image")->nullable();
			$table->integer("sort_order");
			$table->timestamps();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("brands");
	}
};
