<?php

namespace App\Enums;

use App\Extensions\EnumExtensions;

enum PermissionEnum: string {
	use EnumExtensions;

	case USER_MANAGEMENT_ACCESS = "user_management_access";
	case PERMISSION_CREATE = "permission_create";
	case PERMISSION_EDIT = "permission_edit";
	case PERMISSION_SHOW = "permission_show";
	case PERMISSION_DELETE = "permission_delete";
	case PERMISSION_ACCESS = "permission_access";
	case ROLE_CREATE = "role_create";
	case ROLE_EDIT = "role_edit";
	case ROLE_SHOW = "role_show";
	case ROLE_DELETE = "role_delete";
	case ROLE_ACCESS = "role_access";
	case USER_CREATE = "user_create";
	case USER_EDIT = "user_edit";
	case USER_SHOW = "user_show";
	case USER_DELETE = "user_delete";
	case USER_ACCESS = "user_access";
	case SETTING_EDIT = "setting_edit";
	case CATEGORY_CREATE = "category_create";
	case CATEGORY_EDIT = "category_edit";
	case CATEGORY_SHOW = "category_show";
	case CATEGORY_DELETE = "category_delete";
	case CATEGORY_ACCESS = "category_access";
	case BANNER_CREATE = "banner_create";
	case BANNER_EDIT = "banner_edit";
	case BANNER_SHOW = "banner_show";
	case BANNER_DELETE = "banner_delete";
	case BANNER_ACCESS = "banner_access";
	case ORDER_CREATE = "order_create";
	case ORDER_EDIT = "order_edit";
	case ORDER_SHOW = "order_show";
	case ORDER_DELETE = "order_delete";
	case ORDER_ACCESS = "order_access";
	case PAYMENT_ACCESS = "payment_access";
	case PAYMENT_SHOW = "payment_show";
	case PAYMENT_DELETE = "payment_delete";

	// Tags
	case TAG_CREATE = "tag_create";
	case TAG_EDIT = "tag_edit";
	case TAG_DELETE = "tag_delete";
	case TAG_ACCESS = "tag_access";

	// Options
	case OPTION_CREATE = "option_create";
	case OPTION_EDIT = "option_edit";
	case OPTION_DELETE = "option_delete";
	case OPTION_ACCESS = "option_access";

	// Brands
	case BRAND_ACCESS = "brand_access";
	case BRAND_CREATE = "brand_create";
	case BRAND_EDIT = "brand_edit";
	case BRAND_DELETE = "brand_delete";

	// Product
	case PRODUCT_MANAGE = "product_manage";
	case PRODUCT_SHOW = "product_show";
	case PRODUCT_DELETE = "product_delete";
	case PRODUCT_ACCESS = "product_access";
}
