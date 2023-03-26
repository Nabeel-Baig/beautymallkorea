<?php

namespace App\Models;

use App\Enums\DimensionClass;
use App\Enums\ProductPromotion;
use App\Enums\ProductShipping;
use App\Enums\ProductStockBehaviour;
use App\Enums\WeightClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
		"dimension_length",
		"dimension_width",
		"dimension_height",
		"dimension_class",
		"weight",
		"weight_class",
		"image",
		"secondary_images",
		"min_order_quantity",
		"subtract_stock",
		"require_shipping",
		"promotion_status",
	];

	protected $casts = [
		"subtract_stock" => ProductStockBehaviour::class,
		"require_shipping" => ProductShipping::class,
		"promotion_status" => ProductPromotion::class,
		"dimension_class" => DimensionClass::class,
		"weight_class" => WeightClass::class,
		"secondary_images" => "array",
	];

	final public function categories(): BelongsToMany {
		return $this->belongsToMany(Category::class, "category_products", "product_id", "category_id")->withTimestamps();
	}

	final public function tags(): BelongsToMany {
		return $this->belongsToMany(Tag::class, "product_tags", "product_id", "tag_id")->withTimestamps();
	}

	final public function productOptions(): HasMany {
		return $this->hasMany(ProductOption::class, "product_id", "id");
	}

	final public function optionValues(): BelongsToMany {
		return $this->belongsToMany(OptionValue::class, "product_options", "product_id", "option_value_id")
			->withPivot(["id", "product_id", "option_value_id", "quantity", "subtract_stock", "price_difference", "price_adjustment"])
			->withTimestamps();
	}

	final public function relatedProducts(): BelongsToMany {
		return $this->belongsToMany(self::class, "related_products", "product_id", "related_product_id")->withTimestamps();
	}

	final public function brand(): BelongsTo {
		return $this->belongsTo(Brand::class, "brand_id", "id");
	}

	final public function orderItems(): HasMany {
		return $this->hasMany(OrderItem::class, "product_id", "id");
	}

	/** @noinspection MethodVisibilityInspection */
	protected static function booted(): void {
		static::creating(static function (self $product) {
			$product->slug = Str::slug($product->name);
		});
	}
}
