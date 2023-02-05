<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model {
	protected $table = "product_options";
	protected $fillable = ["product_id", "option_value_id", "quantity", "subtract_stock", "price_difference", "price_adjustment"];
}
