<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum AuthPermissionConstraint {
	use EnumExtensions;

	case AUTHORIZE_ANY;
	case AUTHORIZE_ALL;
}
