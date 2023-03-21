<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	final public function run(): void {
		$users = [
			[
				"id" => 1,
				"name" => "Nabeel Baig",
				"email" => "mathswithnabeel@gmail.com",
				"password" => Hash::make("Google@6233"),
				"phone" => "923333906233",
				"avatar" => "images/avatar-1.jpg",
				"is_authenticate" => 0,
				"remember_token" => null,
				"created_at" => "2021-06-21 07:11:07",
				"updated_at" => "2021-06-21 07:11:07",
			],
			[
				"id" => 2,
				"name" => "Admin",
				"email" => "nabeel@outsourcetoasia.co",
				"password" => Hash::make("Abcd1234"),
				"phone" => "923333906233",
				"avatar" => "images/avatar-1.jpg",
				"is_authenticate" => 0,
				"remember_token" => null,
				"created_at" => "2021-06-21 07:11:07",
				"updated_at" => "2021-06-21 07:11:07",
			],
		];
		User::insert($users);

		$users = [];
		$names = ["Steve", "Albert", "Robert", "Ricardo", "Marc", "Rihana", "Peter", "John"];
		foreach ($names as $name) {
			$users[] = [
				"name" => $name,
				"email" => strtolower($name) . "@gmail.com",
				"password" => Hash::make("Abcd1234"),
				"phone" => "923333906233",
				"is_authenticate" => 0,
				"remember_token" => null,
				"created_at" => "2021-06-21 07:11:07",
				"updated_at" => "2021-06-21 07:11:07",
			];
		}
		User::insert($users);
	}
}
