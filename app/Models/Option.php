<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model {
	protected $table = "options";
	protected $fillable = ["name"];

	final public function optionValues(): HasMany {
		return $this->hasMany(OptionValue::class, "option_id", "id");
	}
}
