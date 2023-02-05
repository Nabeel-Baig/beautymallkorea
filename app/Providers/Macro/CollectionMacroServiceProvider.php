<?php

namespace App\Providers\Macro;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacroServiceProvider extends ServiceProvider {
	final public function boot(): void {
		if (!Collection::hasMacro("flattenTree")) {
			Collection::macro("flattenTree", function (string $childrenField) {
				$result = collect();

				foreach ($this as $item) {
					$result->push($item);

					if ($item->$childrenField instanceof Collection) {
						$result = $result->merge($item->$childrenField->flattenTree($childrenField));

						unset($item[$childrenField]);
					}
				}

				return $result;
			});
		}
	}
}
