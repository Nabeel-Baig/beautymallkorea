<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>

                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards"><?php echo app('translator')->get('translation.Dashboards'); ?></span>
                    </a>
                </li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_management_access')): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-user"></i>
                            <span><?php echo app('translator')->get('translation.User_Management'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_access')): ?>
                                <li><a href="<?php echo e(route('admin.permissions.index')); ?>" key="t-products">Permissions</a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                                <li><a href="<?php echo e(route('admin.roles.index')); ?>" key="t-product-detail">Roles</a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
                                <li><a href="<?php echo e(route('admin.users.index')); ?>" key="t-product-detail">Users</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_edit')): ?>
                    <li>
                        <a href="<?php echo e(route('admin.settings.edit',$setting->id)); ?>" class="waves-effect">
                            <i class="bx bx-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH /media/nabeel/SSD/xampp/htdocs/beauty/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>