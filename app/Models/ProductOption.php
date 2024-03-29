<?php

namespace App\Models;

use App\Enums\ProductOptionUnitAdjustment;
use App\Enums\ProductStockBehaviour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model {
	use SoftDeletes;

	protected $table = "product_options";

	protected $fillable = [
		"product_id",
		"option_value_id",
		"quantity",
		"subtract_stock",
		"weight_difference",
		"weight_adjustment",
		"price_difference",
		"price_adjustment",
	];

	protected $casts = [
		"subtract_stock" => ProductStockBehaviour::class,
		"weight_adjustment" => ProductOptionUnitAdjustment::class,
		"price_adjustment" => ProductOptionUnitAdjustment::class,
	];

	final public function product(): BelongsTo {
		return $this->belongsTo(Product::class, "product_id", "id");
	}

	final public function optionValue(): BelongsTo {
		return $this->belongsTo(OptionValue::class, "option_value_id", "id");
	}

	final public function orderItems(): HasMany {
		return $this->hasMany(OrderItem::class, "product_option_id", "id");
	}

	final public function wishlistProducts(): HasMany {
		return $this->hasMany(Wishlist::class, "product_option_id", "id");
	}
}
