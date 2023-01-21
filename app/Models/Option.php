<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends BaseModel {
	protected $fillable = ["name"];

	final public function optionValues(): HasMany {
		return $this->hasMany(OptionValue::class, "option_id", "id");
	}
}
