<?php $__env->startSection('title'); ?> Create <?php echo e($title); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Plugins css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> <?php echo e($title); ?> <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e("Edit ".$title); ?> <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <!-- end row -->
    <div class="row" xmlns="http://www.w3.org/1999/html">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="<?php echo e(route('admin.settings.update', [$setting->id])); ?>" class="custom-validation" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','name'))); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($setting->name ?? ''); ?>" name="name" id="name"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','name'))); ?>" required/>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','title'))); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($setting->title ?? ''); ?>" name="title" id="title"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','title'))); ?>" required/>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','email'))); ?></label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($setting->email ?? ''); ?>" name="email" id="email"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','email'))); ?>" required/>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','phone'))); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($setting->phone ?? ''); ?>" name="phone" id="phone"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','phone'))); ?>" required/>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','address'))); ?></label>
                            <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="address" id="address"
                                      placeholder="<?php echo e(ucwords(str_replace('_',' ','address'))); ?>" required><?php echo e($setting->address ?? ''); ?></textarea>
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','link'))); ?></label>
                            <input type="url" class="form-control"
                                   value="<?php echo e($setting->link ?? ''); ?>" name="link" id="link"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','link'))); ?>"/>
                        </div>

                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','logo'))); ?></label>
                            <input type="file" id="logo" class="dropify" name="logo" data-height="200">
                            <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label><?php echo e(ucwords(str_replace('_',' ','favico'))); ?></label>
                            <input type="file" id="favico" class="dropify" name="favico" data-height="200">
                            <?php $__errorArgs = ['favico'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/libs/parsleyjs/parsleyjs.min.js')); ?>"></script>
    <!-- Plugins js -->
    <script src="<?php echo e(asset('assets/js/pages/form-validation.init.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script-bottom'); ?>
    <script>
        $(function () {
            $('#logo').dropify({
                defaultFile: "<?php echo e(asset($setting->logo)); ?>",
                messages: {
                    'default': 'Drop a file OR click',
                }
            });

            $('#favico').dropify({
                defaultFile: "<?php echo e(asset($setting->favico)); ?>",
                messages: {
                    'default': 'Drop a file OR click',
                }
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/domainname/public/beauty/resources/views/admin/settings/form.blade.php ENDPATH**/ ?>