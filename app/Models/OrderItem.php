<?php

namespace App\Models;

use App\Casts\OrderItemProductOption;
use App\Casts\ProductDimension;
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
		"product_weight_class",
		"product_dimension",
		"product_dimension_class",
		"product_image",
		"product_price",
		"product_total_price",
	];

	protected $casts = [
		"product_dimension" => ProductDimension::class,
		"product_option_name" => OrderItemProductOption::class,
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
