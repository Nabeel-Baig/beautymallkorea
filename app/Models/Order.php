<?php

namespace App\Models;

use App\Casts\OrderAddress;
use App\Casts\OrderDetails;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\ShippingMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
	use SoftDeletes;

	protected $table = "orders";
	protected $fillable = [
		"customer_id",
		"first_name",
		"last_name",
		"email",
		"contact",
		"shipping_first_name",
		"shipping_last_name",
		"shipping_email",
		"shipping_contact",
		"billing_address",
		"shipping_address",
		"order_details",
		"order_status",
		"payment_method",
		"shipping_method",
		"actual_amount",
		"discount_amount",
		"shipping_amount",
		"total_amount",
	];
	protected $casts = [
		"billing_address" => OrderAddress::class,
		"shipping_address" => OrderAddress::class,
		"order_details" => OrderDetails::class,
		"order_status" => OrderStatus::class,
		"payment_method" => PaymentMethod::class,
		"shipping_method" => ShippingMethod::class,
	];

	final public function customer(): BelongsTo {
		return $this->belongsTo(Customer::class, "customer_id", "id");
	}

	final public function orderItems(): HasMany {
		return $this->hasMany(OrderItem::class, "order_id", "id");
	}
}
