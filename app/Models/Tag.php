<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model {
	protected $table = "tags";
	protected $fillable = ["name", "slug", "is_active"];

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
