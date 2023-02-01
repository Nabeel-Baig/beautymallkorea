<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Option;
use App\Models\Product;
use App\Models\Tag;
use App\Policies\AccessPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		Tag::class => AccessPolicy::class,
		Option::class => AccessPolicy::class,
		Product::class => AccessPolicy::class,
		Brand::class => AccessPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	final public function boot(): void {
		$this->registerPolicies();

		//
	}
}
