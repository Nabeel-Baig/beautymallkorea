<?php

namespace App\Providers\Json;

use App\Json\CountryJson;
use Illuminate\Support\ServiceProvider;

class JsonLoaderServiceProvider extends ServiceProvider {
	public array $singletons = [
		CountryJson::class,
	];
}
