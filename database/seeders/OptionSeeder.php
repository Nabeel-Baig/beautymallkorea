<?php

namespace Database\Seeders;

use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder {
	final public function run(): void {
		$timestamp = Carbon::now()->toDateTimeString();
		$options = [];

		for ($index = 1; $index <= 100; $index++) {
			$identifier = str_pad($index, 3, "0", STR_PAD_LEFT);

			$options[] = [
				"name" => "Option $identifier",
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		Option::insert($options);
	}
}
