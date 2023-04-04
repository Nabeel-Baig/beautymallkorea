<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tag extends Model {
	use SoftDeletes;

	protected $table = "tags";

	protected $fillable = [
		"name",
		"slug",
	];

	final public function products(): BelongsToMany {
		return $this->belongsToMany(Product::class, "product_tags", "tag_id", "product_id")->withTimestamps();
	}

	/** @noinspection MethodVisibilityInspection */
	protected static function booted(): void {
		static::creating(static function (self $tag) {
			$tag->slug = Str::slug($tag->name);
		});
	}
}
