<?php

use App\Enums\CouponType;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
			$table->string('name',50);
			$table->string('code',50);
			$table->unsignedTinyInteger('type')->default(CouponType::PERCENTAGE->value);
			$table->decimal('discount',50);
			$table->date('date_start');
			$table->date('date_end');
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
