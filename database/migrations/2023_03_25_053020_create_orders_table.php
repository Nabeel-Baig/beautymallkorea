<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\ShippingMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	final public function up(): void {
		Schema::create("orders", static function (Blueprint $table) {
			$table->id();

			// Customer information
			$table->foreignId("customer_id")->nullable()->constrained()->nullOnDelete();
			$table->string("first_name", 32);
			$table->string("last_name", 32);
			$table->string("email");
			$table->string("contact", 32);

			// Customer shipping information
			$table->string("shipping_first_name", 32);
			$table->string("shipping_last_name", 32);
			$table->string("shipping_email");
			$table->string("shipping_contact", 32);

			// Customer addresses
			$table->text("billing_address");
			$table->text("shipping_address");

			// Order details
			$table->text("comment")->nullable();
			$table->string("ip_address", 50)->nullable();
			$table->string("user_agent", 100)->nullable();
			$table->unsignedTinyInteger("order_status")->default(OrderStatus::PENDING->value);
			$table->unsignedTinyInteger("payment_method")->default(PaymentMethod::CASH_ON_DELIVERY);
			$table->unsignedTinyInteger("shipping_method")->default(ShippingMethod::FLAT_SHIPPING);

			// Pricing details
			$table->decimal("actual_amount")->default(0.00);
			$table->decimal("discount_amount")->default(0.00);
			$table->decimal("shipping_amount")->default(0.00);
			$table->decimal("total_amount")->default(0.00);

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
		Schema::dropIfExists("orders");
	}
};
