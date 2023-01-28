<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
			$table->enum('banner_type',['slider','banner','promotion_event','promotion_brand','delivery_banner'])->default('banner');
			$table->string('title')->nullable();
			$table->string('link')->nullable();
			$table->string('image');
			$table->integer('sort_order');
            $table->timestamps();
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
