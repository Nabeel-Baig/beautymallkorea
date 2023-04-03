<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum CouponType: int
{
	use EnumExtensions;

	case PERCENTAGE = 0;
	case FIXED_AMOUNT = 1;
}
