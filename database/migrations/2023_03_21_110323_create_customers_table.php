<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("customers", static function (Blueprint $table) {
			$table->id();
			$table->string("first_name", 32);
			$table->string("last_name", 32);
			$table->string("profile_picture");
			$table->string("email")->unique();
			$table->string("password");
			$table->string("contact");
			$table->boolean("customer_verified")->default(false);
			$table->text("customer_details")->nullable();
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
		Schema::dropIfExists("customers");
	}
}
