<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {
	use SoftDeletes;

	protected $table = "addresses";

	protected $fillable = [
		"customer_id",
		"is_default",
		"address_line_one",
		"address_line_two",
		"address_city",
		"address_state",
		"address_country",
		"address_zip_code",
	];
	protected $casts = [
		"is_default" => "bool",
	];

	final public function customer(): BelongsTo {
		return $this->belongsTo(Customer::class, "customer_id", "id");
	}
}
