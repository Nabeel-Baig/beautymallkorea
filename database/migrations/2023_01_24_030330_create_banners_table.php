<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("banners", static function (Blueprint $table) {
			$table->id();
			$table->enum("banner_type", ["slider", "banner", "promotion_event", "promotion_brand", "delivery_banner"])->default("banner");
			$table->string("title")->nullable();
			$table->string("link")->nullable();
			$table->string("image");
			$table->integer("sort_order");
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
		Schema::dropIfExists("banners");
	}
}
