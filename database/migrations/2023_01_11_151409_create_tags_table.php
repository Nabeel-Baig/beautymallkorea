<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration {
	final public function up(): void {
		Schema::create("tags", static function (Blueprint $table) {
			$table->id();
			$table->string("name");
			$table->timestamps();
		});
	}

	final public function down(): void {
		Schema::dropIfExists('tags');
	}
}
