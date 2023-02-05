<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCurrenciesTable extends Migration {
	final public function up(): void {
		Schema::dropIfExists('currencies');
	}

	final public function down(): void {
		Schema::create('currencies', static function (Blueprint $table) {
			$table->id();
			$table->string("name", 50);
			$table->string("symbol", 3);
			$table->string("short_name", 3);
			$table->timestamps();
		});
	}
}
