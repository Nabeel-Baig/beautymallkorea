<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
	use SoftDeletes;

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
		"comment",
		"ip_address",
		"user_agent",
		"order_status",
		"payment_method",
		"shipping_method",
		"actual_amount",
		"discount_amount",
		"shipping_amount",
		"total_amount",
	];

	protected $casts = [
		"billing_address" => "json",
		"shipping_address" => "json"
	];
}
