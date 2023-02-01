<?php

namespace App\Models;

use App\Enums\RequireShipping;
use App\Enums\SubtractStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Product extends Model {
	protected $table = "products";
	protected $fillable = [
		"brand_id",
		"name",
		"slug",
		"description",
		"meta_title",
		"meta_description",
		"meta_keywords",
		"sku",
		"upc",
		"price",
		"discount_price",
		"quantity",
		"image",
		"secondary_images",
		"min_order_quantity",
		"subtract_stock",
		"require_shipping",
	];

	protected $casts = [
		"subtract_stock" => SubtractStock::class,
		"require_shipping" => RequireShipping::class,
		"secondary_images" => "array",
	];

	final public function categories(): BelongsToMany {
		return $this->belongsToMany(Category::class, "category_products", "product_id", "category_id")->withTimestamps();
	}

	final public function tags(): BelongsToMany {
		return $this->belongsToMany(Tag::class, "product_tags", "product_id", "tag_id")->withTimestamps();
	}

	final public function optionValues(): BelongsToMany {
		return $this->belongsToMany(OptionValue::class, "product_options", "product_id", "option_value_id")
			->withPivot(["quantity", "subtract_stock", "price_difference", "price_adjustment"])
			->withTimestamps();
	}

	final public function relatedProducts(): BelongsToMany {
		return $this->belongsToMany(self::class, "related_products", "product_id", "related_product_id")->withTimestamps();
	}

	/** @noinspection MethodVisibilityInspection */
	protected static function booted(): void {
		static::creating(static function (self $product) {
			$product->slug = Str::slug($product->name);
		});
	}
}
