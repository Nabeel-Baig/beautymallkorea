<?php

namespace App\Models;

use App\Casts\BrandCountry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model {
	protected $table = "brands";
	protected $fillable = ["name", "slug", "country", "brand_image", "sort_order", "brand_banner_image"];
	protected $casts = [
		"country" => BrandCountry::class,
	];

	final public function products(): HasMany {
		return $this->hasMany(Product::class, "brand_id", "id");
	}

	/** @noinspection MethodVisibilityInspection */
	protected static function booted(): void {
		static::creating(static function (self $brand) {
			$brand->slug = Str::slug($brand->name);
		});
	}
}
