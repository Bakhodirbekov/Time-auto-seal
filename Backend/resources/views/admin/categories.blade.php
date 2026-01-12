@extends('layouts.admin')

@section('page_title', 'Kategoriyalar')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Categories List -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Kategoriyalar ro'yxati</h3>
            <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-secondary transition">Yangi qo'shish</button>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($categories as $category)
            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-{{ $category->icon ?? 'folder' }} text-gray-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">{{ $category->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $category->subcategories->count() }} ta subkategoriya</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Add Category Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Yangi kategoriya</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomi</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent" placeholder="Kategoriya nomi">
            </div>
            <button type="submit" class="w-full py-3 bg-accent text-white font-bold rounded-lg hover:bg-orange-600 transition">Saqlash</button>
        </form>
    </div>
</div>
@endsection
