<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum ShippingMethod: int {
	use EnumExtensions;

	case FREE_SHIPPING = 0;
	case FLAT_SHIPPING = 1;
}
