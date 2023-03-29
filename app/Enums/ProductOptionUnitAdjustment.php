<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum ProductOptionUnitAdjustment: int {
	use EnumExtensions;

	case POSITIVE = 1;
	case NEGATIVE = 0;
}
