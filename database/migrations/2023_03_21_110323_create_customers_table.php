<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration {
	final public function up(): void {
		Schema::create("customers", static function (Blueprint $table) {
			$table->id();
			$table->string("first_name");
			$table->string("last_name");
			$table->string("profile_picture");
			$table->string("email")->unique();
			$table->string("password");
			$table->string("contact");
			$table->text("customer_details")->default("");
			$table->timestamps();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("customers");
	}
}
