<?php

namespace App\Providers\Macro;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class RedirectResponseMacroServiceProvider extends ServiceProvider {
	final public function boot(): void {
		RedirectResponse::macro('withSuccessToastr', function (string $message): RedirectResponse {
			/** @noinspection PhpUndefinedMethodInspection */
			return $this->withToastSuccess($message);
		});

		RedirectResponse::macro('withCreatedSuccessToastr', function (string $name): RedirectResponse {
			return $this->withSuccessToastr("$name Created Successfully");
		});

		RedirectResponse::macro('withUpdatedSuccessToastr', function (string $name): RedirectResponse {
			return $this->withSuccessToastr("$name Updated Successfully");
		});
	}
}
