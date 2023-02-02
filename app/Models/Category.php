<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Category extends Model {
	use SoftDeletes;

	protected $fillable = [
		'category_id',
		'name',
		'description',
		'meta_tag_title',
		'meta_tag_description',
		'meta_tag_keywords',
		'slug',
		'sort_order',
		'image',
		'type',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $dates = [
		'updated_at',
		'created_at',
		'deleted_at',
	];

	final public function childrenCategories(): HasMany {
		return $this->hasMany(self::class, "category_id", "id")->with("childrenCategories");
	}

	final public function products(): BelongsToMany {
		return $this->belongsToMany(Product::class, "category_products", "category_id", "product_id")->withTimestamps();
	}

	final public function flattenedChildrenCategories(): Collection {
		return $this->childrenCategories()->get()->flattenTree("childrenCategories");
	}
}
