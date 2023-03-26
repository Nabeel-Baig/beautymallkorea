<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum ProductShipping: int {
	use EnumExtensions;

	case SHIPPING_NOT_REQUIRED = 0;
	case SHIPPING_REQUIRED = 1;
}
