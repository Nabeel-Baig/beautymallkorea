<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
			$table->foreignId('customer_id')->constrained('customers')->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId('product_id')->constrained('products')->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId("product_option_id")->constrained("product_options")->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
