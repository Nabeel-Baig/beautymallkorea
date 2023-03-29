<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {
	final public function up(): void {
		Schema::create("settings", static function (Blueprint $table) {
			$table->id();
			$table->string("name")->nullable();
			$table->string("title")->nullable();
			$table->string("logo")->nullable();
			$table->string("footer_logo")->nullable();
			$table->string("favico")->nullable();
			$table->string("email")->nullable();
			$table->string("phone")->nullable();
			$table->text("address")->nullable();
			$table->string("link")->nullable();
			$table->string("currency")->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("settings");
	}
}
