<?php

namespace App\Models;

use App\Casts\CustomerDetails;
use App\ValueObjects\CustomerDetailsValueObject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as IAuthenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as ICanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Model implements IAuthenticatable, ICanResetPassword, JWTSubject {
	use Authenticatable, CanResetPassword, Notifiable;

	protected $table = "customers";
	protected $fillable = ["first_name", "last_name", "email", "password", "profile_picture", "contact", "customer_verified", "customer_details"];
	protected $casts = [
		"customer_details" => CustomerDetails::class,
	];

	final public function updateCurrentActiveIp(): self {
		$request = app(Request::class);

		$customerDetails = $this->customer_details ?? $this->createCustomerDetails();
		$customerDetails->setCurrentActiveIp($request->ip());

		return $this;
	}


	final public function getJWTIdentifier(): string {
		return $this->getKey();
	}

	final public function getJWTCustomClaims(): array {
		return ["customer" => $this];
	}

	/**
	 * @noinspection MethodVisibilityInspection
	 */
	protected static function booted(): void {
		static::creating(static function (self $customer) {
			$customer->updateCurrentActiveIp();
			$customer->password = Hash::make($customer->password);
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
