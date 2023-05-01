<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("tags", static function (Blueprint $table) {
			$table->id();
			$table->string("name")->unique();
			$table->string("slug")->unique();
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
		Schema::dropIfExists("tags");
	}
}
