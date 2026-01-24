@extends('layouts.admin')

@section('page_title', 'Yangi banner qo\'shish')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Yangi banner qo'shish</h2>
        <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fas fa-arrow-left"></i>
            <span>Orqaga qaytish</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Banner rasmi (21:9 tavsiya etiladi)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-accent transition cursor-pointer relative bg-gray-50">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-image text-gray-400 text-3xl mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-accent hover:text-orange-600 focus-within:outline-none">
                                    <span>Rasm yuklash</span>
                                    <input id="image" name="image" type="file" class="sr-only" required onchange="previewImage(this)">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF (Max. 2MB)</p>
                        </div>
                        <img id="image_preview" class="absolute inset-0 w-full h-full object-cover rounded-xl hidden">
                    </div>
                    @error('image')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sarlavha (Ixtiyoriy)</label>
                    <input type="text" name="title" value="{{ old('title') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                        placeholder="Masalan: Yangi avtomobillar to'plami">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Havola (URL)</label>
                    <input type="url" name="link" value="{{ old('link') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                        placeholder="https://example.com/promo">
                    @error('link')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tavsif (Ixtiyoriy)</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                        placeholder="Banner haqida qisqacha ma'lumot...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tartib raqami</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Holati</label>
                        <select name="is_active" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition">
                            <option value="1">Faol</option>
                            <option value="0">O'chirilgan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex gap-4">
                <button type="submit" class="flex-1 bg-accent text-white font-bold py-3 px-8 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-accent/20">
                    Bannerni saqlash
                </button>
                <a href="{{ route('admin.banners.index') }}" class="flex-1 bg-gray-100 text-gray-600 font-bold py-3 px-8 rounded-xl hover:bg-gray-200 transition text-center">
                    Bekor qilish
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image_preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
