@extends('layouts.admin')

@section('page_title', 'Bannerni tahrirlash')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Bannerni tahrirlash</h2>
        <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fas fa-arrow-left"></i>
            <span>Orqaga qaytish</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
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
                        <img id="image_preview" src="{{ $banner->image_url }}" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                    </div>
                    @error('image')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sarlavha (Ixtiyoriy)</label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                        placeholder="Masalan: Yangi avtomobillar to'plami">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Havola (URL)</label>
                    <input type="url" name="link" value="{{ old('link', $banner->link) }}" 
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
                        placeholder="Banner haqida qisqacha ma'lumot...">{{ old('description', $banner->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tartib raqami</label>
                        <input type="number" name="order" value="{{ old('order', $banner->order) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Holati</label>
                        <select name="is_active" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition">
                            <option value="1" {{ $banner->is_active ? 'selected' : '' }}>Faol</option>
                            <option value="0" {{ !$banner->is_active ? 'selected' : '' }}>O'chirilgan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex gap-4">
                <button type="submit" class="flex-1 bg-accent text-white font-bold py-3 px-8 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-accent/20">
                    O'zgarishlarni saqlash
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
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
