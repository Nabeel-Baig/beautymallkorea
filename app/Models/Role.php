<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {
	use SoftDeletes;

	public $table = "roles";

	protected $fillable = [
		"title",
		"created_at",
		"updated_at",
		"deleted_at",
	];

	final public function users(): BelongsToMany {
		return $this->belongsToMany(User::class);
	}

	final public function permissions(): BelongsToMany {
		return $this->belongsToMany(Permission::class);
	}
}
