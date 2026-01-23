

<?php $__env->startSection('page_title', 'Yangi avtomobil qo\'shish'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Avtomobil ma'lumotlari</h3>
        </div>
        <div class="p-6">
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.cars.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sarlavha</label>
                        <input type="text" name="title" value="<?php echo e(old('title')); ?>" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Masalan: Chevrolet Gentra 2022 Ideal holatda">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategoriya</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="">Tanlang...</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Narxi (so'm)</label>
                        <input type="number" name="price" value="<?php echo e(old('price')); ?>" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="15000000">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brend</label>
                        <input type="text" name="brand" value="<?php echo e(old('brand')); ?>" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Chevrolet">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" value="<?php echo e(old('model')); ?>" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Gentra">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yili</label>
                        <input type="number" name="year" value="<?php echo e(old('year')); ?>" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="2022">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yurgani (km)</label>
                        <input type="number" name="mileage" value="<?php echo e(old('mileage')); ?>" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="50000">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yoqilg'i turi</label>
                        <select name="fuel_type" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="Benzin">Benzin</option>
                            <option value="Gaz">Gaz</option>
                            <option value="Dizel">Dizel</option>
                            <option value="Elektr">Elektr</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Uzatmalar qutisi</label>
                        <select name="transmission" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="Avtomat">Avtomat</option>
                            <option value="Mexanik">Mexanik</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Holati</label>
                        <select name="condition" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="Yangi">Yangi</option>
                            <option value="Ishlatilgan">Ishlatilgan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Aloqa telefon raqami</label>
                        <input type="tel" name="contact_phone" value="<?php echo e(old('contact_phone')); ?>" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="+998901234567">
                        <p class="mt-1 text-xs text-gray-500">Xaridorlar qo'ng'iroq qilishi uchun</p>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tavsif</label>
                        <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Avtomobil haqida batafsil ma'lumot..."><?php echo e(old('description')); ?></textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rasmlar (Bir nechta tanlash mumkin)</label>
                        <input type="file" name="images[]" multiple required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                        <p class="mt-1 text-xs text-gray-500">Birinchi tanlangan rasm asosiy hisoblanadi.</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="<?php echo e(route('admin.cars')); ?>" class="px-6 py-2 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition">Bekor qilish</a>
                    <button type="submit" class="px-6 py-2 bg-accent text-white rounded-lg hover:bg-orange-600 transition font-bold">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Guccifer\Desktop\honest-wheels-main\Time-auto-seal\Backend\resources\views\admin\create_car.blade.php ENDPATH**/ ?>