<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum PaymentMethod: int {
	use EnumExtensions;

	case CASH_ON_DELIVERY = 0;
	case BANK_TRANSFER = 1;
	case PAYPAL = 2;
	case STRIPE = 3;
}
