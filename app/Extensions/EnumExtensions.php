<?php

namespace App\Extensions;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonException;
use stdClass;
use UnitEnum;

trait EnumExtensions {
	public static function formattedName(UnitEnum $enumEntry): string {
		return Str::of($enumEntry->name)->title()->headline()->toString();
	}

	/**
	 * @throws JsonException
	 */
	public static function formattedNameValueArray(): array {
		return array_map(static function (UnitEnum $enumEntry) {
			$jsonEnum = new stdClass();
			$jsonEnum->name = self::formattedName($enumEntry);
			$jsonEnum->value = $enumEntry->value;

			return $jsonEnum;
		}, self::cases());
	}

	public static function random(): self {
		return Arr::random(self::cases());
	}
}
