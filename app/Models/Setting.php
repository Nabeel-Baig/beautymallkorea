<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model {
	use SoftDeletes;

	public $table = "settings";

	protected $fillable = [
		"name",
		"title",
		"logo",
		"footer_logo",
		"favico",
		"email",
		"phone",
		"address",
		"link",
		"currency",
		"created_at",
		"updated_at",
		"deleted_at",
	];
}
