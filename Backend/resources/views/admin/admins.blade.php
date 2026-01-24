@extends('layouts.admin')

@section('page_title', 'Adminlar')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Tizim adminlari</h3>
            <p class="text-sm text-gray-500">Administratorlar va moderatorlarni boshqarish</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="px-6 py-2.5 bg-accent text-white rounded-xl text-sm hover:bg-orange-600 transition font-bold shadow-lg shadow-accent/20 flex items-center gap-2">
            <i class="fas fa-plus"></i> Yangi admin qo'shish
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase font-bold tracking-wider">
                    <th class="px-6 py-4">Foydalanuvchi</th>
                    <th class="px-6 py-4">Rol</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Qo'shilgan sana</th>
                    <th class="px-6 py-4 text-right">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($admins as $admin)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary font-bold overflow-hidden border border-gray-100">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&color=FFFFFF&background=0D1B2A" alt="{{ $admin->name }}">
                            </div>
                            <div>
                                <span class="font-bold text-gray-800 block leading-tight">{{ $admin->name }}</span>
                                @if($admin->id == auth()->id())
                                    <span class="text-[10px] bg-green-100 text-green-700 px-1.5 py-0.5 rounded uppercase font-bold">Siz</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 {{ $admin->role == 'superadmin' ? 'bg-red-100 text-red-800' : ($admin->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800') }} rounded-lg text-[10px] font-black uppercase tracking-wide">
                            {{ $admin->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $admin->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $admin->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="w-9 h-9 flex items-center justify-center text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition" title="Tahrirlash">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($admin->id != auth()->id())
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Haqiqatdan ham ushbu adminni o\'chirmoqchimisiz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="O'chirish">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
