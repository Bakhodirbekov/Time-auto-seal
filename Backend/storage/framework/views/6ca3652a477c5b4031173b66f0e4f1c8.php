

<?php $__env->startSection('page_title', 'Avtomobillar'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Barcha avtomobillar</h3>
        <div class="flex items-center space-x-4">
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.cars', ['status' => 'pending'])); ?>" class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-sm">Kutilayotganlar</a>
                <a href="<?php echo e(route('admin.cars', ['status' => 'approved'])); ?>" class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm">Tasdiqlanganlar</a>
                <a href="<?php echo e(route('admin.cars')); ?>" class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm">Barchasi</a>
            </div>
            <a href="<?php echo e(route('admin.cars.create')); ?>" class="px-4 py-2 bg-accent text-white rounded-lg text-sm font-bold hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i> Yangi qo'shish
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">Rasm</th>
                    <th class="px-6 py-4">Sarlavha</th>
                    <th class="px-6 py-4">Narxi</th>
                    <th class="px-6 py-4">Telefon</th>
                    <th class="px-6 py-4">Kategoriya</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <img src="<?php echo e($car->images->first()->image_url ?? 'https://via.placeholder.com/60x40'); ?>" class="w-16 h-10 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <?php echo e($car->title); ?>

                        <div class="text-xs text-gray-500"><?php echo e($car->brand); ?> <?php echo e($car->model); ?> (<?php echo e($car->year); ?>)</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">$<?php echo e(number_format($car->price)); ?></td>
                    <td class="px-6 py-4">
                        <?php if($car->contact_phone): ?>
                            <a href="tel:<?php echo e($car->contact_phone); ?>" class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg transition text-sm font-medium">
                                <i class="fas fa-phone"></i>
                                <?php echo e($car->contact_phone); ?>

                            </a>
                        <?php else: ?>
                            <span class="text-xs text-gray-400">Yo'q</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($car->category->name ?? 'Noma\'lum'); ?></td>
                    <td class="px-6 py-4">
                        <?php if($car->status == 'pending'): ?>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Kutilmoqda</span>
                        <?php elseif($car->status == 'approved'): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Tasdiqlangan</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs uppercase"><?php echo e($car->status); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <?php if($car->status == 'pending'): ?>
                                <form action="<?php echo e(route('admin.cars.approve', $car->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded" title="Tasdiqlash"><i class="fas fa-check"></i></button>
                                </form>
                            <?php endif; ?>
                            
                            <form action="<?php echo e(route('admin.cars.toggle-hot-deal', $car->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="p-2 <?php echo e($car->is_hot_deal ? 'text-red-600' : 'text-gray-400'); ?> hover:bg-red-50 rounded" title="Hot Deal"><i class="fas fa-bolt"></i></button>
                            </form>

                            <a href="<?php echo e(route('admin.cars.edit', $car->id)); ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit"></i></a>
                            
                            <form action="<?php echo e(route('admin.cars.destroy', $car->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        <?php echo e($cars->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\honest-wheels-main\Backend\resources\views/admin/cars.blade.php ENDPATH**/ ?>