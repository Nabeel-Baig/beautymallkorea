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
	public static function formattedJsonArray(): string {
		$formattedJsonObject = array_map(static function (UnitEnum $enumEntry) {
			$jsonEnum = new stdClass();
			$jsonEnum->name = self::formattedName($enumEntry);
			$jsonEnum->value = $enumEntry->value;

			return $jsonEnum;
		}, self::cases());

		return json_encode($formattedJsonObject, JSON_THROW_ON_ERROR);
	}

	public static function random(): self {
		return Arr::random(self::cases());
	}
}
