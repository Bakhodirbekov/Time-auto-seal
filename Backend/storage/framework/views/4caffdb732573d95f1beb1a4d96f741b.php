

<?php $__env->startSection('page_title', 'Bildirishnomalar'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Tizim bildirishnomalari</h3>
        <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-secondary transition">Yangi yuborish</button>
    </div>
    <div class="divide-y divide-gray-100">
        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="p-6 hover:bg-gray-50 transition">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800"><?php echo e($notification->title); ?></h4>
                        <p class="text-sm text-gray-600 mt-1"><?php echo e($notification->message); ?></p>
                        <div class="flex items-center space-x-4 mt-3">
                            <span class="text-xs text-gray-400"><i class="fas fa-user mr-1"></i> <?php echo e($notification->user->name ?? 'Tizim'); ?></span>
                            <span class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> <?php echo e($notification->created_at->diffForHumans()); ?></span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="p-2 text-gray-400 hover:text-red-600 rounded"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="p-10 text-center text-gray-500">Bildirishnomalar topilmadi</div>
        <?php endif; ?>
    </div>
    <div class="p-4 border-t border-gray-100">
        <?php echo e($notifications->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\Time-auto-seal\Backend\resources\views\admin\notifications.blade.php ENDPATH**/ ?>