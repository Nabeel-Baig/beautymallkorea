<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends BaseModel {
	protected $fillable = ["name", "image"];

	final public function option(): BelongsTo {
		return $this->belongsTo(Option::class, "option_id", "id");
	}
}
