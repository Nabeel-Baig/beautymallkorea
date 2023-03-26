<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum DimensionClass: int {
	use EnumExtensions;

	case INCH = 0;
	case FEET = 1;
	case METER = 2;
	case CENTIMETER = 3;
}
