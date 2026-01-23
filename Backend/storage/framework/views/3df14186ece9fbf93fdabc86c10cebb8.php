

<?php $__env->startSection('page_title', 'Sozlamalar'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <h3 class="text-xl font-bold text-gray-800 mb-8 border-b pb-4">Tizim sozlamalari</h3>
    
    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="space-y-6">
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700"><?php echo e($setting->description ?? $setting->key); ?></label>
                    <span class="text-xs text-gray-400"><?php echo e($setting->key); ?></span>
                </div>
                <div class="md:col-span-2">
                    <?php if($setting->type == 'boolean'): ?>
                        <select name="settings[<?php echo e($setting->key); ?>]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                            <option value="1" <?php echo e($setting->value == '1' ? 'selected' : ''); ?>>Ha / Yoqilgan</option>
                            <option value="0" <?php echo e($setting->value == '0' ? 'selected' : ''); ?>>Yo'q / O'chirilgan</option>
                        </select>
                    <?php elseif($setting->type == 'integer'): ?>
                        <input type="number" name="settings[<?php echo e($setting->key); ?>]" value="<?php echo e($setting->value); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                    <?php else: ?>
                        <input type="text" name="settings[<?php echo e($setting->key); ?>]" value="<?php echo e($setting->value); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="mt-10 pt-6 border-t border-gray-100">
            <button type="submit" class="bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-secondary transition shadow-lg">Sozlamalarni saqlash</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\Time-auto-seal\Backend\resources\views\admin\settings.blade.php ENDPATH**/ ?>