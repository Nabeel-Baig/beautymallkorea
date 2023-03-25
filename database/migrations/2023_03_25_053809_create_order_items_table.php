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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

			$table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
			$table->foreignId('product_id')->constrained('products');
			$table->foreignId('options_id')->constrained('options');
			$table->string('product_name')->nullable();
			$table->string('product_qty')->nullable();
			$table->string('product_weight')->nullable();
			$table->string('product_image')->nullable();
			$table->json('product_options')->nullable();
			$table->decimal('product_price')->nullable();
			$table->string('product_total_price')->nullable();

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
        Schema::dropIfExists('order_items');
    }
};
