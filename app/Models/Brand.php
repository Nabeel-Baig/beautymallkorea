<?php

namespace App\Models;

use App\Casts\BrandCountry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model {
	protected $table = "brands";
	protected $fillable = ["name", "slug", "country", "brand_image", "sort_order"];
	protected $casts = [
		"country" => BrandCountry::class,
	];

	/** @noinspection MethodVisibilityInspection */
	protected static function booted(): void {
		static::creating(static function (self $brand) {
			$brand->slug = Str::slug($brand->name);
		});
	}
}
