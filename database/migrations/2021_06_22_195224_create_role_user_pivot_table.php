<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserPivotTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("role_user", static function (Blueprint $table) {
			$table->foreignId("role_id")->unsigned()->constrained()->cascadeOnDelete();
			$table->foreignId("user_id")->unsigned()->constrained()->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	final public function down(): void {
		Schema::dropIfExists("role_user");
	}
}
