<?php

namespace App\Models;

use App\Casts\BrandCountry;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model {
	protected $table = "brands";
	protected $fillable = ["name", "country", "country_image", "brand_image", "sort_order"];
	protected $casts = [
		"country" => BrandCountry::class,
	];
}
