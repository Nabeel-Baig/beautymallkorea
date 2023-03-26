<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum ProductPromotion: int {
	use EnumExtensions;

	case NOT_IN_PROMOTION = 0;
	case IN_PROMOTION = 1;
}
