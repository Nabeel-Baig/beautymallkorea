<?php $__env->startSection('title'); ?> Create <?php echo e($title); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Plugins css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php
        if (request()->segment(3) == 'create') {
            $action = route("admin.categories.store");
            $page = 'Create';
        } elseif (request()->segment(4) == 'edit') {
            $action = route("admin.categories.update", [$category->id]);
            $page = 'Edit';
        }
    ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> <?php echo e($title); ?> <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($page." ".$title); ?> <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <!-- end row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="<?php echo e($action); ?>" class="custom-validation" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if(request()->segment(4) == 'edit'): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label">Select <?php echo e(ucwords(str_replace('_',' ','type'))); ?></label>
                            <select name="type" id="type" class="form-control <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select <?php echo e(ucwords(str_replace('_',' ','type'))); ?></option>
                                <option value="category">Category</option>
                                <option value="brand">Brand</option>
                            </select>
                            <?php $__errorArgs = ['type'];
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

                        <div class="mb-3">
                            <label class="form-label">Select <?php echo e(ucwords(str_replace('_',' ','parent_category'))); ?></label>
                            <select name="category_id" id="category_id" class="form-control <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select <?php echo e(ucwords(str_replace('_',' ','parent_category'))); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(!empty($category->id) ? (($id === $category->id) ? "selected" : "") : ''); ?>><?php echo e($categories); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
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

                        <div class="mb-3">
                            <label><?php echo e(ucwords(str_replace('_',' ','name'))); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($category->name ?? ''); ?>" name="name" id="name"
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
                        <input type="hidden" id="slug" name="slug"
                                       value="<?php echo e(!empty($record->slug)?$record->slug:''); ?>" data-validation="required">

                        <div class="mb-3">
                            <label><?php echo e(ucwords(str_replace('_',' ','description'))); ?></label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   name="description" id="elm1"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','description'))); ?>" required/><?php echo e($category->description ?? ''); ?></textarea>
                            <?php $__errorArgs = ['description'];
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

                        <div class="mb-3">
                            <label><?php echo e(ucwords(str_replace('_',' ','meta_tag_title'))); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['meta_tag_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($category->meta_tag_title ?? ''); ?>" name="meta_tag_title" id="meta_tag_title"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','meta_tag_title'))); ?>"/>
                        </div>

                        <div class="mb-3">
                            <label><?php echo e(ucwords(str_replace('_',' ','meta_tag_description'))); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['meta_tag_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($category->meta_tag_description ?? ''); ?>" name="meta_tag_description" id="meta_tag_description"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','meta_tag_description'))); ?>"/>
                        </div>

                        <div class="mb-3">
                            <label><?php echo e(ucwords(str_replace('_',' ','meta_tag_keywords'))); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['meta_tag_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($category->meta_tag_keywords ?? ''); ?>" name="meta_tag_keywords" id="meta_tag_keywords"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','meta_tag_keywords'))); ?>"/>
                        </div>

                        <div class="mb-3">
                            <label><?php echo e(ucwords(str_replace('_',' ','sort_order'))); ?></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> parsley-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($category->sort_order ?? ''); ?>" name="sort_order" id="sort_order"
                                   placeholder="<?php echo e(ucwords(str_replace('_',' ','sort_order'))); ?>" required/>
                            <?php $__errorArgs = ['sort_order'];
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

                        <div class="mb-3">
                            <label><?php echo e(ucwords(str_replace('_',' ','image'))); ?></label>
                            <input type="file" id="image" class="dropify" name="image" data-height="200">
                            <?php $__errorArgs = ['image'];
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

                        <div class="mb-3">
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
    <!--tinymce js-->
    <script src="<?php echo e(asset('assets/libs/tinymce/tinymce.min.js')); ?>"></script>
    <!-- init js -->
    <script src="<?php echo e(asset('assets/js/pages/form-editor.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script-bottom'); ?>
    <script>
        $(function () {
            $('#image').dropify({
                defaultFile: "<?php echo e(asset($category->image ?? '')); ?>",
                messages: {
                    'default': 'Drop a file OR click',
                }
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\beauty\resources\views/admin/categories/form.blade.php ENDPATH**/ ?>