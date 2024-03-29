<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model {
	use SoftDeletes;

	public $table = "permissions";

	protected $fillable = [
		"title",
		"created_at",
		"updated_at",
		"deleted_at",
	];

	final public function roles(): BelongsToMany {
		return $this->belongsToMany(Role::class);
	}
}
