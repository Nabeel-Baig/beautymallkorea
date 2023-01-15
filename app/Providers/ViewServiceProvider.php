<?php

namespace App\Providers;

use App\View\Composers\SettingComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {
	/**
	 * Register services.
	 *
	 * @return void
	 */
	final public function register(): void {
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	final public function boot(): void {
		View::composer('*', SettingComposer::class);
	}
}
