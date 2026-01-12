@extends('layouts.admin')

@section('page_title', 'Yangi avtomobil qo\'shish')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Avtomobil ma'lumotlari</h3>
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

            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sarlavha</label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Masalan: Chevrolet Gentra 2022 Ideal holatda">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategoriya</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                            <option value="">Tanlang...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Narxi (so'm)</label>
                        <input type="number" name="price" value="{{ old('price') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="15000000">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brend</label>
                        <input type="text" name="brand" value="{{ old('brand') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Chevrolet">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" value="{{ old('model') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Gentra">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yili</label>
                        <input type="number" name="year" value="{{ old('year') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="2022">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yurgani (km)</label>
                        <input type="number" name="mileage" value="{{ old('mileage') }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="50000">
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
                        <input type="tel" name="contact_phone" value="{{ old('contact_phone') }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="+998901234567">
                        <p class="mt-1 text-xs text-gray-500">Xaridorlar qo'ng'iroq qilishi uchun</p>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tavsif</label>
                        <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition" placeholder="Avtomobil haqida batafsil ma'lumot...">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rasmlar (Bir nechta tanlash mumkin)</label>
                        <input type="file" name="images[]" multiple required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition">
                        <p class="mt-1 text-xs text-gray-500">Birinchi tanlangan rasm asosiy hisoblanadi.</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.cars') }}" class="px-6 py-2 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition">Bekor qilish</a>
                    <button type="submit" class="px-6 py-2 bg-accent text-white rounded-lg hover:bg-orange-600 transition font-bold">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
