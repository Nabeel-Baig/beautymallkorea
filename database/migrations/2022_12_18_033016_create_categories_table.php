<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('meta_tag_title');
            $table->text('meta_tag_description')->nullable();
            $table->text('meta_tag_keywords')->nullable();
            $table->string('slug')->unique();
            $table->integer('sort_order');
            $table->string('image')->nullable();
            $table->enum('type',['category','brand'])->default('category');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
