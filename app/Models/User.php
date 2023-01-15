<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'dob',
		'avatar',
		'phone',
		'address',
		'gender',
		'theme',
		'created_at',
		'updated_at',
		'deleted_at',
		'remember_token',
		'email_verified_at',
		'two_factor_code',
		'two_factor_code',
		'two_factor_expires_at',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $dates = [
		'updated_at',
		'created_at',
		'deleted_at',
		'email_verified_at',
		'two_factor_expires_at',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	protected $with = ["roles.permissions"];

	public function roles(): BelongsToMany
	{
		return $this->belongsToMany(Role::class);
	}

	final public function orders(): hasMany
	{
		return $this->hasMany(Order::class);
	}

	public function generateTwoFactorCode()
	{
		$this->timestamps = false;
		$this->two_factor_code = rand(100000, 999999);
		$this->two_factor_expires_at = now()->addMinutes(10);
		$this->save();
	}

	public function resetTwoFactorCode()
	{
		$this->timestamps = false;
		$this->two_factor_code = null;
		$this->two_factor_expires_at = null;
		$this->save();
	}

	/* public function scopeCountUserRole()
	{
		return DB::table('role_user')->where('user_id',\auth()->user()->id)->whereIn('role_id',[1,2])->count();
	} */
}
