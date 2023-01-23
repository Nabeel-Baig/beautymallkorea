<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
	use HasFactory;
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

	/*final public function childrenCategory(): HasMany
	{
		return $this->hasMany(__CLASS__);
	}

	final public function parentCategory(): BelongsTo
	{
		return $this->belongsTo(__CLASS__);
	}*/

	final public function childrenCategories(): HasMany
	{
		return $this->hasMany(__CLASS__)->with('childrenCategories');
	}

	final public function products(): BelongsToMany {
		return $this->belongsToMany(Product::class, "category_products", "category_id", "product_id")->withTimestamps();
	}
}
