<?php

namespace App\Models;

use App\Enums\ProductOptionUnitAdjustment;
use App\Enums\ProductStockBehaviour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOption extends Model {
	protected $table = "product_options";
	protected $fillable = ["product_id", "option_value_id", "quantity", "subtract_stock", "weight_difference", "weight_adjustment", "price_difference", "price_adjustment"];
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
}
