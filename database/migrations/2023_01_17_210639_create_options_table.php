<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration {
	final public function up(): void {
		Schema::create("options", static function (Blueprint $table) {
			$table->id();
			$table->string("name");
			$table->timestamps();
		});
	}

	final public function down(): void {
		Schema::dropIfExists("options");
	}
}
