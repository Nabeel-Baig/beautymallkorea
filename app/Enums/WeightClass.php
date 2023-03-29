<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum WeightClass: int {
	use EnumExtensions;

	case KILOGRAM = 0;
	case POUND = 1;
}
