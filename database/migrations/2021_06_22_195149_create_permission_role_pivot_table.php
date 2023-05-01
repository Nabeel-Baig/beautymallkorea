<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRolePivotTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("permission_role", static function (Blueprint $table) {
			$table->foreignId("role_id")->unsigned()->constrained()->cascadeOnDelete();
			$table->foreignId("permission_id")->unsigned()->constrained()->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	final public function down(): void {
		Schema::dropIfExists("permission_role");
	}
}
