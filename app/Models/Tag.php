<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model {
	protected $table = "tags";
	public $fillable = ["name", "is_active"];

	final public function products(): BelongsToMany {
		return $this->belongsToMany(Product::class, "product_tags", "tag_id", "product_id")->withTimestamps();
	}
}
