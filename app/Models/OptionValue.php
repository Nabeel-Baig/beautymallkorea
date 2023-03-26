<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OptionValue extends Model {
	protected $table = "option_values";

	protected $fillable = [
		"name",
		"image",
	];

	final public function option(): BelongsTo {
		return $this->belongsTo(Option::class, "option_id", "id");
	}

	final public function productOptions(): HasMany {
		return $this->hasMany(ProductOption::class, "option_value_id", "id");
	}

	final public function products(): BelongsToMany {
		return $this->belongsToMany(Product::class, "product_options", "option_value_id", "product_id")
			->withPivot(["id", "product_id", "option_value_id", "quantity", "subtract_stock", "price_difference", "price_adjustment"])
			->withTimestamps();
	}
}
