<?php

namespace App\Models;

use App\Casts\CustomerDetails;
use App\ValueObjects\CustomerDetailsValueObject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as IAuthenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as ICanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Model implements IAuthenticatable, ICanResetPassword, JWTSubject {
	use Authenticatable, CanResetPassword, Notifiable;

	protected $table = "customers";

	protected $fillable = [
		"first_name",
		"last_name",
		"email",
		"password",
		"profile_picture",
		"contact",
		"customer_verified",
		"customer_details",
	];

	protected $casts = [
		"customer_details" => CustomerDetails::class,
	];

	final public function addresses(): HasMany {
		return $this->hasMany(Address::class, "customer_id", "id");
	}

	final public function orders(): HasMany {
		return $this->hasMany(Order::class, "customer_id", "id");
	}

	final public function updateCurrentActiveIp(): self {
		$request = app(Request::class);

		$customerDetails = $this->customer_details ?? $this->createCustomerDetails();
		$customerDetails->setCurrentActiveIp($request->ip());

		return $this;
	}

	final public function updatePassword(string $plainPassword): self {
		$this->password = Hash::make($plainPassword);

		return $this;
	}

	final public function verifyPassword(string $plainPassword): bool {
		return Hash::check($plainPassword, $this->password);
	}

	final public function getJWTIdentifier(): string {
		return $this->getKey();
	}

	final public function getJWTCustomClaims(): array {
		return ["customer" => Arr::only($this->attributes, ["first_name", "last_name", "email", "profile_picture", "contact"])];
	}

	/**
	 * @noinspection MethodVisibilityInspection
	 */
	protected static function booted(): void {
		static::creating(static function (self $customer) {
			$customer->updateCurrentActiveIp()->updatePassword($customer->password);
			$customer->profile_picture ??= "/assets/uploads/customers/default-profile.jpg";
		});

		static::updating(static function (self $customer) {
			$customer->updateCurrentActiveIp();
		});
	}

	private function createCustomerDetails(): CustomerDetailsValueObject {
		return new CustomerDetailsValueObject();
	}
}
