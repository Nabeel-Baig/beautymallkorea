<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {
	protected $table = "category_products";

	protected $fillable = [
		"product_id",
		"category_id",
	];
}
