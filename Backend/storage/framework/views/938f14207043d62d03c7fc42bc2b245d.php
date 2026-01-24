

<?php $__env->startSection('page_title', 'Bannerni tahrirlash'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Bannerni tahrirlash</h2>
        <a href="<?php echo e(route('admin.banners.index')); ?>" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fas fa-arrow-left"></i>
            <span>Orqaga qaytish</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="<?php echo e(route('admin.banners.update', $banner)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="space-y-6">
                <!-- Current Image & Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Banner rasmi (21:9 tavsiya etiladi)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-accent transition cursor-pointer relative bg-gray-50 h-48 overflow-hidden">
                        <div class="space-y-1 text-center self-center z-10 bg-white/60 p-2 rounded-lg">
                            <i class="fas fa-camera text-gray-400 text-2xl mb-1"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer font-medium text-accent hover:text-orange-600 focus-within:outline-none">
                                    <span>Rasmni almashtirish</span>
                                    <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(this)">
                                </label>
                            </div>
                        </div>
                        <img id="image_preview" src="<?php echo e($banner->image_url); ?>" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                    </div>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sarlavha (Ixtiyoriy)</label>
                    <input type="text" name="title" value="<?php echo e(old('title', $banner->title)); ?>" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                        placeholder="Masalan: Yangi avtomobillar to'plami">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Link -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Havola (URL)</label>
                    <input type="url" name="link" value="<?php echo e(old('link', $banner->link)); ?>" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                        placeholder="https://example.com/promo">
                    <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tavsif (Ixtiyoriy)</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                        placeholder="Banner haqida qisqacha ma'lumot..."><?php echo e(old('description', $banner->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tartib raqami</label>
                        <input type="number" name="order" value="<?php echo e(old('order', $banner->order)); ?>" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Holati</label>
                        <select name="is_active" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition">
                            <option value="1" <?php echo e($banner->is_active ? 'selected' : ''); ?>>Faol</option>
                            <option value="0" <?php echo e(!$banner->is_active ? 'selected' : ''); ?>>O'chirilgan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex gap-4">
                <button type="submit" class="flex-1 bg-accent text-white font-bold py-3 px-8 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-accent/20">
                    O'zgarishlarni saqlash
                </button>
                <a href="<?php echo e(route('admin.banners.index')); ?>" class="flex-1 bg-gray-100 text-gray-600 font-bold py-3 px-8 rounded-xl hover:bg-gray-200 transition text-center">
                    Bekor qilish
                </a>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image_preview');
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\Time-auto-seal\Backend\resources\views/admin/edit_banner.blade.php ENDPATH**/ ?>