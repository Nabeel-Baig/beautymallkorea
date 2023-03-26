<?php

namespace App\Enums;

enum ShippingMethod: int {
	case FREE_SHIPPING = 0;
	case FLAT_SHIPPING = 1;
}
