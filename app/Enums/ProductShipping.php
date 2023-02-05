<?php

namespace App\Enums;

enum ProductShipping: int {
	case SHIPPING_NOT_REQUIRED = 0;
	case SHIPPING_REQUIRED = 1;
}
