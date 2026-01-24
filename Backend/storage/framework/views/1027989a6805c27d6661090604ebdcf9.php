

<?php $__env->startSection('page_title', 'Shikoyatlar'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Tizimdagi shikoyatlar</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Avtomobil</th>
                    <th class="px-6 py-4">Mavzu</th>
                    <th class="px-6 py-4">Holati</th>
                    <th class="px-6 py-4">Sana</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800"><?php echo e($complaint->user->name ?? 'Noma\'lum'); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($complaint->user->email ?? ''); ?></div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($complaint->car->title ?? 'Noma\'lum'); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($complaint->subject); ?></td>
                    <td class="px-6 py-4">
                        <?php if($complaint->status == 'pending'): ?>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Yangi</span>
                        <?php elseif($complaint->status == 'resolved'): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Yopilgan</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs"><?php echo e($complaint->status); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($complaint->created_at->diffForHumans()); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <?php if($complaint->status == 'pending'): ?>
                                <form action="<?php echo e(route('admin.complaints.resolve', $complaint->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded" title="Yopish"><i class="fas fa-check"></i></button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        <?php echo e($complaints->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\Time-auto-seal\Backend\resources\views/admin/complaints.blade.php ENDPATH**/ ?>