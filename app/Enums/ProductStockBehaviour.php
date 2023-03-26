<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum ProductStockBehaviour: int {
	use EnumExtensions;

	case CONSISTENT_STOCK = 0;
	case SUBTRACT_STOCK = 1;
}


