<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OptionValueSeeder extends Seeder {
	final public function run(): void {
		$options = Option::all();
		$optionValues = [];
		$timestamp = Carbon::now()->toDateTimeString();

		foreach ($options as $option) {

			for ($index = 1; $index <= 25; $index++) {
				$optionIdentifier = str_pad($option->id, 3, "0", STR_PAD_LEFT);
				$optionValueIdentifier = str_pad($index, 2, "0", STR_PAD_LEFT);

				$optionValues[] = [
					"option_id" => $option->id,
					"name" => "Option Value $optionIdentifier - $optionValueIdentifier",
					"created_at" => $timestamp,
					"updated_at" => $timestamp,
				];
			}
		}

		OptionValue::insert($optionValues);
	}
}
