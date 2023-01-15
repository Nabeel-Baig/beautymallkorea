<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends BaseModel {
	use SoftDeletes;

	public $fillable = ["name", "is_active"];
}
