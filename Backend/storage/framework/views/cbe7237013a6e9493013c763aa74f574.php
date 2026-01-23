

<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Jami avtomobillar</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['total_cars'])); ?></h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-car text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Aktiv taymerlar</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['active_timers'])); ?></h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                <i class="fas fa-clock text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Bugun joylangan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['today_listed'])); ?></h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <i class="fas fa-plus-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Tez sotish</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['hot_deals'])); ?></h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                <i class="fas fa-bolt text-red-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Foydalanuvchilar</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['total_users'])); ?></h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">So'nggi ro'yxatdan o'tgan userlar</h3>
        </div>
        <div class="divide-y divide-gray-100">
            <?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="p-4 hover:bg-gray-50 flex items-center space-x-4">
                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&color=7F9CF5&background=EBF4FF" alt="User avatar" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800"><?php echo e($user->name); ?></h4>
                    <p class="text-sm text-gray-600"><?php echo e($user->phone ?? $user->email); ?></p>
                </div>
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Yangi</span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="p-4 border-t border-gray-100">
            <a href="<?php echo e(route('admin.users')); ?>" class="text-accent hover:text-orange-700 font-medium flex items-center justify-center">
                Barchasini ko'rish
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Active Categories -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Eng faol kategoriyalar</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <?php $__currentLoopData = $activeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $percentage = $stats['total_cars'] > 0 ? ($category->cars_count / $stats['total_cars']) * 100 : 0;
                ?>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700"><?php echo e($category->name); ?></span>
                        <span class="text-sm font-medium text-gray-700"><?php echo e($category->cars_count); ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-xl p-6 text-white">
            <h3 class="text-lg font-semibold mb-4">Taymer boshqaruvi</h3>
            <p class="text-sm opacity-90 mb-4">24 soatlik avtomatik taymerlarni boshqaring</p>
            <a href="<?php echo e(route('admin.timers')); ?>" class="inline-block bg-accent hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition text-center">
                <i class="fas fa-play-circle mr-2"></i>
                Taymerlarni ko'rish
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">E'lon qo'shish</h3>
            <p class="text-sm text-gray-600 mb-4">Yangi avtomobil e'lonini tizimga qo'shish</p>
            <a href="<?php echo e(route('admin.cars.create')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition text-center">
                <i class="fas fa-plus mr-2"></i>
                Yangi qo'shish
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Shikoyatlar</h3>
            <p class="text-sm text-gray-600 mb-4">Foydalanuvchilar tomonidan yuborilgan shikoyatlar</p>
            <a href="<?php echo e(route('admin.complaints')); ?>" class="inline-block bg-gray-800 hover:bg-black text-white font-medium py-2 px-4 rounded-lg transition text-center">
                <i class="fas fa-flag mr-2"></i>
                Shikoyatlarni ko'rish
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\Time-auto-seal\Backend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>