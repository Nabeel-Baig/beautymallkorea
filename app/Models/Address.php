<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
	protected $table = "addresses";
	protected $fillable = ["customer_id", "is_default", "address_line_one", "address_line_two", "address_city", "address_state", "address_country", "address_zip_code"];
	protected $casts = [
		"is_default" => "bool",
	];
}
