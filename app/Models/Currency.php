<?php

namespace App\Models;

class Currency extends BaseModel {
	public $fillable = ["name", "symbol", "short_name"];
}
