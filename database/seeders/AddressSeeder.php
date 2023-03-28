<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AddressSeeder extends Seeder {
	/**
	 * @throws Exception
	 */
	final public function run(): void {
		$addresses = [];
		$now = Carbon::now()->toDateTimeString();
		$customers = Customer::select(["id"])->get();

		foreach ($customers as $customer) {
			$numberOfAddressesForCurrentCustomer = random_int(1, 6);
			$defaultAddressIndex = random_int(0, $numberOfAddressesForCurrentCustomer - 1);

			for ($addressIndex = 0; $addressIndex < $numberOfAddressesForCurrentCustomer; $addressIndex++) {
				$addresses[] = [
					"customer_id" => $customer->id,
					"is_default" => $addressIndex === $defaultAddressIndex,
					"address_line_one" => fake()->streetAddress,
					"address_line_two" => fake()->buildingNumber,
					"address_city" => fake()->city,
					"address_state" => fake()->streetName,
					"address_country" => fake()->country,
					"address_zip_code" => fake()->postcode,
					"created_at" => $now,
					"updated_at" => $now,
				];
			}
		}

		Address::insert($addresses);
	}
}
