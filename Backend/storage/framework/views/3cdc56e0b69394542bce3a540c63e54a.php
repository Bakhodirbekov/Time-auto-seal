

<?php $__env->startSection('page_title', 'Tez sotish (Hot Deals)'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Aktiv Hot Deal e'lonlar</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">Rasm</th>
                    <th class="px-6 py-4">Avtomobil</th>
                    <th class="px-6 py-4">Narxi</th>
                    <th class="px-6 py-4">Kategoriya</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <img src="<?php echo e($car->images->first()->image_url ?? 'https://via.placeholder.com/60x40'); ?>" class="w-16 h-10 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800"><?php echo e($car->title); ?></div>
                        <div class="text-xs text-red-500 font-bold uppercase tracking-wider"><i class="fas fa-bolt"></i> HOT DEAL</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700"><?php echo e(number_format($car->price)); ?> so'm</td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($car->category->name ?? 'Noma\'lum'); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <form action="<?php echo e(route('admin.cars.toggle-hot-deal', $car->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-sm">O'chirish</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">Hozircha hot deallar yo'q</td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\Time-auto-seal\Backend\resources\views\admin\hot_deals.blade.php ENDPATH**/ ?>