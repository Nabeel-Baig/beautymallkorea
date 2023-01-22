<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OptionValue extends Model {
	protected $fillable = ["name", "image"];

	final public function option(): BelongsTo {
		return $this->belongsTo(Option::class, "option_id", "id");
	}

	final public function products(): BelongsToMany {
		return $this->belongsToMany(Product::class, "product_options", "option_value_id", "product_id")
			->withPivot(["quantity", "subtract_stock", "price_difference", "price_adjustment"])
			->withTimestamps();
	}
}
