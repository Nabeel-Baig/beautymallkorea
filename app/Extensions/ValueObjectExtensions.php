<?php

namespace App\Extensions;

use JsonException;

trait ValueObjectExtensions {
	/**
	 * @throws JsonException
	 */
	final public function convertToJson(): string {
		return json_encode($this, JSON_THROW_ON_ERROR);
	}
}
