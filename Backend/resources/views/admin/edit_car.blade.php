@extends('layouts.admin')

@section('page_title', 'Avtomobilni tahrirlash')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Ma'lumotlarni o'zgartirish</h3>
        </div>
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sarlavha</label>
                        <input type="text" name="title" value="{{ old('title', $car->title) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategoriya</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $car->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Narxi ($)</label>
                        <input type="number" name="price" value="{{ old('price', $car->price) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brend</label>
                        <input type="text" name="brand" value="{{ old('brand', $car->brand) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" value="{{ old('model', $car->model) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yili</label>
                        <input type="number" name="year" value="{{ old('year', $car->year) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yurgani (km)</label>
                        <input type="number" name="mileage" value="{{ old('mileage', $car->mileage) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yoqilg'i turi</label>
                        <select name="fuel_type" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="Benzin" {{ $car->fuel_type == 'Benzin' ? 'selected' : '' }}>Benzin</option>
                            <option value="Gaz" {{ $car->fuel_type == 'Gaz' ? 'selected' : '' }}>Gaz</option>
                            <option value="Dizel" {{ $car->fuel_type == 'Dizel' ? 'selected' : '' }}>Dizel</option>
                            <option value="Elektr" {{ $car->fuel_type == 'Elektr' ? 'selected' : '' }}>Elektr</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Uzatmalar qutisi</label>
                        <select name="transmission" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="Avtomat" {{ $car->transmission == 'Avtomat' ? 'selected' : '' }}>Avtomat</option>
                            <option value="Mexanik" {{ $car->transmission == 'Mexanik' ? 'selected' : '' }}>Mexanik</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Holati</label>
                        <select name="condition" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="Yangi" {{ $car->condition == 'Yangi' ? 'selected' : '' }}>Yangi</option>
                            <option value="Ishlatilgan" {{ $car->condition == 'Ishlatilgan' ? 'selected' : '' }}>Ishlatilgan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Aloqa telefon raqami</label>
                        <input type="tel" name="contact_phone" value="{{ old('contact_phone', $car->contact_phone) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="+998901234567">
                        <p class="mt-1 text-xs text-gray-500">Xaridorlar qo'ng'iroq qilishi uchun</p>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tavsif</label>
                        <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">{{ old('description', $car->description) }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Joriy rasmlar</label>
                        <div class="grid grid-cols-4 gap-4 mt-2">
                            @foreach($car->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-24 object-cover rounded-lg">
                                    <button type="button" onclick="deleteImage({{ $image->id }})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yangi rasmlar qo'shish</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                        <p class="text-xs text-gray-500 mt-1">Ko'p rasmlarni birga tanlashingiz mumkin (JPEG, PNG, JPG, GIF - max 2MB)</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.cars') }}" class="px-6 py-2 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition">Bekor qilish</a>
                    <button type="submit" class="px-6 py-2 bg-accent text-white rounded-lg hover:bg-orange-600 transition font-bold">Yangilash</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteImage(imageId) {
    if (confirm('Rasmni o\'chirmoqchimisiz?')) {
        fetch(`/admin/cars/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Xatolik yuz berdi!');
            }
        })
        .catch(error => {
            alert('Xatolik yuz berdi!');
        });
    }
}
</script>
@endsection
