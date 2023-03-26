<?php

namespace App\Enums;

enum OrderStatus: int {
	case PENDING = 0;
	case SHIPPED = 1;
	case COMPLETE = 2;
	case CANCELLED = 3;
	case CANCELLED_REVERSAL = 4;
	case CHARGEBACK = 5;
	case DENIED = 6;
	case EXPIRED = 7;
	case FAILED = 8;
	case REFUNDED = 9;
}
