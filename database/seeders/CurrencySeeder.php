<?php

namespace Database\Seeders;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder {
	final public function run(): void {
		$timestamp = Carbon::now()->toDateTimeString();
		$currencies = [
			["name" => "Pakistani Rupee", "symbol" => "Rs.", "short_name" => "PKR"],
			["name" => "United States Dollar", "symbol" => "$", "short_name" => "USD"],
		];

		array_map(static function (array $currency) use ($timestamp) {
			$currency["created_at"] = $timestamp;
			$currency["updated_at"] = $timestamp;

			return $currency;
		}, $currencies);

		Currency::insert($currencies);
	}
}
