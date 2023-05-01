<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionValuesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("option_values", static function (Blueprint $table) {
			$table->id();
			$table->foreignId("option_id")->constrained("options")->cascadeOnUpdate()->cascadeOnDelete();
			$table->string("name");
			$table->string("image")->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	final public function down(): void {
		Schema::dropIfExists("option_values");
	}
}
