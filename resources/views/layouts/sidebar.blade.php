@php use App\Enums\PermissionEnum; @endphp
	<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

	<div data-simplebar class="h-100">

		<!--- Sidemenu -->
		<div id="sidebar-menu">
			<!-- Left Menu Start -->
			<ul class="metismenu list-unstyled" id="side-menu">
				<li class="menu-title" key="t-menu">@lang('translation.Menu')</li>

				<li>
					<a href="{{ route('admin.dashboard') }}" class="waves-effect">
						<i class="bx bx-home-circle"></i>
						<span key="t-dashboards">@lang('translation.Dashboards')</span>
					</a>
				</li>
				@can('user_management_access')
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect">
							<i class="bx bx-user"></i>
							<span>@lang('translation.User_Management')</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							@can('permission_access')
								<li>
									<a href="{{ route('admin.permissions.index') }}"
									   key="t-products">@lang('translation.Permissions')</a>
								</li>
							@endcan
							@can('role_access')
								<li>
									<a href="{{ route('admin.roles.index') }}"
									   key="t-product-detail">@lang('translation.Roles')</a>
								</li>
							@endcan
							@can('user_access')
								<li>
									<a href="{{ route('admin.users.index') }}"
									   key="t-product-detail">@lang('translation.Users')</a>
								</li>
							@endcan
						</ul>
					</li>
				@endcan
				@can('category_access')
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect">
							<i class="bx bx-store"></i>
							<span>Catalog</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							@can(PermissionEnum::CATEGORY_ACCESS->value)
								<li>
									<a href="{{ route('admin.categories.index') }}" key="t-products">Categories</a>
								</li>
							@endcan
							@can(PermissionEnum::QUICK_CATEGORY_ACCESS->value)
								<li>
									<a href="{{ route('admin.quickcategories.index') }}" key="t-products">Quick Categories</a>
								</li>
							@endcan
							@can(PermissionEnum::BRAND_ACCESS->value)
								<li>
									<a href="{{ route('admin.brands.index') }}" key="t-products">Brands</a>
								</li>
							@endcan
							@can(PermissionEnum::TAG_ACCESS->value)
								<li>
									<a href="{{ route('admin.tags.index') }}" key="t-products">Tags</a>
								</li>
							@endcan
							@can(PermissionEnum::OPTION_ACCESS->value)
								<li>
									<a href="{{ route('admin.options.index') }}" key="t-products">Variants</a>
								</li>
							@endcan
							@can(PermissionEnum::PRODUCT_ACCESS->value)
								<li>
									<a href="{{ route('admin.products.index') }}" key="t-products">Products</a>
								</li>
							@endcan
						</ul>
					</li>
				@endcan
				@can(PermissionEnum::BANNER_ACCESS->value)
					<li>
						<a href="{{ route('admin.banners.index') }}" class="waves-effect">
							<i class="bx bx-cog"></i>
							<span>Banners</span>
						</a>
					</li>
				@endcan
				@can(PermissionEnum::CUSTOMER_ACCESS->value)
					<li>
						<a href="{{ route('admin.customers.index') }}" class="waves-effect">
							<i class="bx bx-cog"></i>
							<span>Customers</span>
						</a>
					</li>
				@endcan
				@can(PermissionEnum::COUPON_ACCESS->value)
					<li>
						<a href="{{ route('admin.coupons.index') }}" class="waves-effect">
							<i class="bx bx-cog"></i>
							<span>Coupons</span>
						</a>
					</li>
				@endcan
				@can('setting_edit')
					<li>
						<a href="{{ route('admin.settings.edit',$setting->id) }}" class="waves-effect">
							<i class="bx bx-cog"></i>
							<span>Settings</span>
						</a>
					</li>
				@endcan
			</ul>
		</div>
		<!-- Sidebar -->
	</div>
</div>
<!-- Left Sidebar End -->
