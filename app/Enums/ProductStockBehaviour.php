<?php

namespace App\Enums;

enum ProductStockBehaviour: int {
	case CONSISTENT_STOCK = 0;
	case SUBTRACT_STOCK = 1;
}
