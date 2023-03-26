<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use HasFactory, Notifiable;

	protected $table = "users";

	protected $fillable = [
		"name",
		"email",
		"password",
		"dob",
		"avatar",
		"phone",
		"address",
		"gender",
		"theme",
		"created_at",
		"updated_at",
		"deleted_at",
		"remember_token",
		"email_verified_at",
		"two_factor_code",
		"two_factor_expires_at",
	];

	protected $hidden = [
		"password",
		"remember_token",
	];

	protected $casts = [
		"email_verified_at" => "datetime",
		"two_factor_expires_at" => "datetime",
	];

	protected $with = [
		"roles.permissions",
	];

	final public function roles(): BelongsToMany {
		return $this->belongsToMany(Role::class);
	}

	final public function orders(): hasMany {
		return $this->hasMany(Order::class);
	}

	/**
	 * @throws Exception
	 */
	final public function generateTwoFactorCode(): void {
		$this->timestamps = false;
		$this->two_factor_code = random_int(100000, 999999);
		$this->two_factor_expires_at = now()->addMinutes(10);
		$this->save();
	}

	final public function resetTwoFactorCode(): void {
		$this->timestamps = false;
		$this->two_factor_code = null;
		$this->two_factor_expires_at = null;
		$this->save();
	}
}
