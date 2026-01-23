@extends('layouts.admin')

@section('page_title', 'Kategoriyalar')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Categories List -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Kategoriyalar ro'yxati</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($categories as $cat)
            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center space-x-4 flex-1">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-{{ $cat->icon ?? 'folder' }} text-gray-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">{{ $cat->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $cat->cars_count ?? 0 }} ta mashina</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.categories.edit', ['id' => $cat->id]) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded transition" title="Tahrirlash">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.categories.destroy', ['id' => $cat->id]) }}" method="POST" onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded transition" title="O'chirish">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-gray-500">
                Kategoriyalar topilmadi
            </div>
            @endforelse
        </div>
    </div>

    <!-- Add/Edit Category Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @if(isset($category) && $category)
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Kategoriyani tahrirlash</h3>
            <form action="{{ route('admin.categories.update', ['id' => $category->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomi</label>
                    <input type="text" name="name" required value="{{ $category->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent" placeholder="Kategoriya nomi">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-accent">
                        <span class="ml-2 text-sm text-gray-700">Faol</span>
                    </label>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-accent text-white font-bold rounded-lg hover:bg-orange-600 transition">Yangilash</button>
                    <a href="{{ route('admin.categories') }}" class="flex-1 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition text-center">Bekor qilish</a>
                </div>
            </form>
        @else
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Yangi kategoriya</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomi</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent" placeholder="Kategoriya nomi">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full py-3 bg-accent text-white font-bold rounded-lg hover:bg-orange-600 transition">Saqlash</button>
            </form>
        @endif
    </div>
</div>
@endsection
