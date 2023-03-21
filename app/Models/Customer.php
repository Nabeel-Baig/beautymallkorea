<?php

namespace App\Models;

use App\Casts\CustomerDetails;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
	protected $table = "customers";
	protected $fillable = ["first_name", "last_name", "email", "password", "profile_picture", "contact", "customer_verified", "customer_details"];
	protected $casts = [
		"customer_details" => CustomerDetails::class,
	];
}
