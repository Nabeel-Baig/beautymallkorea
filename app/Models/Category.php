<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
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
}
