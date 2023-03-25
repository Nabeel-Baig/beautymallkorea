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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

			$table->foreignId('customer_id')->unsigned()->default(0)->constrained()->cascadeOnDelete();
			$table->string('first_name',32);
			$table->string('last_name',32);
			$table->string('email',32);
			$table->string('address');
			$table->string('appartment')->nullable();
			$table->string('phone',32);
			$table->string('postcode',32)->nullable();
			$table->string('country',50)->nullable();
			$table->string('state', 50)->nullable();
			$table->string('city',50)->nullable();
			$table->string('comment')->nullable();
			$table->ipAddress('ip_address')->nullable();
			$table->string('user_agent')->nullable();
			$table->string('shipping_firstname',32)->nullable();
			$table->string('shipping_lastname',32)->nullable();
			$table->string('shipping_address')->nullable();
			$table->string('shipping_phone')->nullable();
			$table->string('shipping_appartment')->nullable();
			$table->string('shipping_postcode',32)->nullable();
			$table->string('shipping_country',50)->nullable();
			$table->string('shipping_state')->nullable();
			$table->string('shipping_city',50)->nullable();
			$table->enum('order_status',['Canceled','Canceled Reversal','Chargeback','Complete','Denied','Expired','Failed','Pending','Refunded','Shipped'])->default('Pending');
			$table->string('payment_method',50)->nullable();
			$table->string('shipping_method',50)->nullable();
			$table->decimal('actual_amount')->default(0.00);
			$table->decimal('discount_amount')->default(0.00);
			$table->decimal('shipping_amount')->default(0.00);
			$table->decimal('total_amount')->default(0.00);

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
        Schema::dropIfExists('orders');
    }
};
