<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'name',
		'code',
		'type',
		'discount',
		'date_start',
		'date_end',
		"created_at",
		"updated_at",
		"deleted_at",
	];

	final public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class,'coupon_categories','coupon_id','category_id')->withTimestamps();
	}

	final public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class,'coupon_products','coupon_id','product_id')->withTimestamps();
	}
}
