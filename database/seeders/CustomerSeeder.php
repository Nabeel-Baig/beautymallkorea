<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\ValueObjects\CustomerDetailsValueObject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use JsonException;

class CustomerSeeder extends Seeder {
	/**
	 * @throws JsonException
	 */
	final public function run(): void {
		$customers = [];
		$now = Carbon::now()->toDateTimeString();
		$passwordHash = Hash::make("password");
		$defaultProfilePicture = "/assets/uploads/customers/default-profile.jpg";

		for ($customerIndex = 0; $customerIndex < 500; $customerIndex++) {
			$customerDetails = new CustomerDetailsValueObject();
			$customerDetails->setCurrentActiveIp(fake()->ipv4);

			$customers[] = [
				"first_name" => fake()->firstName,
				"last_name" => fake()->lastName,
				"profile_picture" => $defaultProfilePicture,
				"email" => fake()->unique()->email,
				"password" => $passwordHash,
				"contact" => fake()->phoneNumber,
				"customer_verified" => Arr::random([true, false]),
				"customer_details" => json_encode($customerDetails, JSON_THROW_ON_ERROR),
				"created_at" => $now,
				"updated_at" => $now,
			];
		}

		Customer::insert($customers);
	}
}
