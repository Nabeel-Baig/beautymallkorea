<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuickCategory extends Model {
	use SoftDeletes;

	protected $table = "quick_categories";

	protected $fillable = [
		"name",
		"image",
		"link",
		"sort_order",
	];
}
