

<?php $__env->startSection('page_title', 'Taymer nazorati'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">Aktiv taymerlar ro'yxati</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">Avtomobil</th>
                    <th class="px-6 py-4">Ega</th>
                    <th class="px-6 py-4">Qolgan vaqt</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800"><?php echo e($car->title); ?></div>
                        <div class="text-xs text-gray-500">ID: <?php echo e($car->id); ?></div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($car->user->name ?? 'Noma\'lum'); ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-lg text-sm font-bold">
                            <?php echo e($car->timer_end_at ? $car->timer_end_at->diffForHumans(now(), true) : 'Noma\'lum'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <form action="<?php echo e(route('admin.timers.expire', $car->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-sm">Tugatish</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">Aktiv taymerlar topilmadi</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        <?php echo e($cars->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\honest-wheels-main\Backend\resources\views/admin/timers.blade.php ENDPATH**/ ?>