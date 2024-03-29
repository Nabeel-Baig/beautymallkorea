<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("users", static function (Blueprint $table) {
			$table->id();
			$table->string("name");
			$table->string("email")->unique();
			$table->timestamp("email_verified_at")->nullable();
			$table->string("password");
			$table->date("dob")->nullable();
			$table->string("avatar")->nullable();
			$table->string("phone")->nullable();
			$table->string("address")->nullable();
			$table->enum("gender", ["Male", "Female"])->default("Male");
			$table->enum("theme", ["dark", "light"])->default("light");
			$table->string("two_factor_code")->nullable();
			$table->dateTime("two_factor_expires_at")->nullable();
			$table->boolean("is_authenticate")->default(false);
			$table->rememberToken();
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
		Schema::dropIfExists("users");
	}
}
