<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model {
	protected $table = "wishlist";

	protected $fillable = [
		"customer_id",
		"product_id",
		"product_option_id",
	];

	final public function customer(): BelongsTo {
		return $this->belongsTo(Customer::class, "customer_id", "id");
	}

	final public function product(): BelongsTo {
		return $this->belongsTo(Product::class, "product_id", "id");
	}

	final public function productOption(): BelongsTo {
		return $this->belongsTo(ProductOption::class, "product_option_id", "id");
	}
}
