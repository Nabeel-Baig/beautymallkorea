<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model {
	use SoftDeletes;

	protected $table = "order_items";

	protected $fillable = [
		"order_id",
		"product_id",
		"product_option_id",
		"product_name",
		"product_option_name",
		"product_quantity",
		"product_weight",
		"product_dimension",
		"product_image",
		"product_price",
		"product_total_price",
	];

	final public function order(): BelongsTo {
		return $this->belongsTo(Order::class, "order_id", "id");
	}

	final public function product(): BelongsTo {
		return $this->belongsTo(Product::class, "product_id", "id");
	}

	final public function productOption(): BelongsTo {
		return $this->belongsTo(ProductOption::class, "product_option_id", "id");
	}
}
