<?php

namespace App\Providers\Macro;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class RedirectResponseMacroServiceProvider extends ServiceProvider {
	final public function boot(): void {
		RedirectResponse::macro(
			'withSuccessToastr', function ($message): RedirectResponse {
			/** @noinspection PhpUndefinedMethodInspection */
			return $this->withToastSuccess($message);
		},
		);
	}
}
