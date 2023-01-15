<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends BaseModel {
	use SoftDeletes;

	public $fillable = ["name", "symbol", "short_name"];
}
