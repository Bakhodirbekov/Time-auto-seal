@extends('layouts.admin')

@section('page_title', 'Adminni tahrirlash')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Adminni tahrirlash</h2>
        <a href="{{ route('admin.admins.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fas fa-arrow-left"></i>
            <span>Orqaga qaytish</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">To'liq ism</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                        placeholder="Masalan: Akmaljon Sobirov">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email manzili</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                        placeholder="admin@example.com">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tizimdagi roli</label>
                    <select name="role" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition @error('role') border-red-500 @enderror">
                        <option value="moderator" {{ old('role', $admin->role) == 'moderator' ? 'selected' : '' }}>Moderator (Cheklangan huquqlar)</option>
                        @if(auth()->user()->role === 'superadmin')
                            <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Administrator (To'liq huquqlar)</option>
                            <option value="superadmin" {{ old('role', $admin->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        @endif
                    </select>
                    @error('role')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Parolni o'zgartirish</h3>
                    <p class="text-sm text-gray-500 mb-6">O'zgartirmaslik uchun parolni bo'sh qoldiring.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Yangi parol</label>
                            <input type="password" name="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                                placeholder="Kamida 6 ta belgi">
                            @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Parolni tasdiqlash</label>
                            <input type="password" name="password_confirmation" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition"
                                placeholder="Parolni qayta kiriting">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex gap-4">
                <button type="submit" class="flex-1 bg-accent text-white font-bold py-3 px-8 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-accent/20">
                    O'zgarishlarni saqlash
                </button>
                <a href="{{ route('admin.admins.index') }}" class="flex-1 bg-gray-100 text-gray-600 font-bold py-3 px-8 rounded-xl hover:bg-gray-200 transition text-center">
                    Bekor qilish
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
