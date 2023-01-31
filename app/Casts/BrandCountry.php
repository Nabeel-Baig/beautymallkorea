<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;

class BrandCountry implements Castable {
	/**
	 * @param array $arguments
	 *
	 * @return string
	 */
	final public static function castUsing(array $arguments): string {
		return BrandCountryCast::class;
	}
}
