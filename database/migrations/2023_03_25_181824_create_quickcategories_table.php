<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
	{
        Schema::create('quickcategories', function (Blueprint $table) {
            $table->id();
			$table->string('name',32);
			$table->string('image');
			$table->string('link');
			$table->integer('sort_order');
            $table->timestamps();
			$table->softDeletes();
        });
    }


    public function down(): void
	{
        Schema::dropIfExists('quickcategories');
    }
};
