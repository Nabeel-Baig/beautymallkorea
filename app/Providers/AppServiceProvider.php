<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	final public function register(): void {
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	final public function boot(): void {
		//
		Schema::defaultStringLength(191);

		DB::listen(static function ($query) {
			Log::info($query->sql, ["bindings" => $query->bindings, "time" => $query->time]);
		});
	}
}
