<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("addresses", static function (Blueprint $table) {
			$table->id();
			$table->foreignId("customer_id")->constrained("customers")->cascadeOnDelete();
			$table->boolean("is_default")->default(false);
			$table->string("address_line_one");
			$table->string("address_line_two")->nullable();
			$table->string("address_city");
			$table->string("address_state");
			$table->string("address_country");
			$table->string("address_zip_code");
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
		Schema::dropIfExists("addresses");
	}
}
