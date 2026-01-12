@extends('layouts.admin')

@section('page_title', 'Adminlar')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Tizim adminlari</h3>
        <button class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-orange-600 transition font-bold">Yangi admin qo'shish</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">Foydalanuvchi</th>
                    <th class="px-6 py-4">Rol</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Sana</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($admins as $admin)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&color=FFFFFF&background=0D1B2A" class="w-8 h-8 rounded-full">
                        <span class="font-medium text-gray-800">{{ $admin->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 {{ $admin->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }} rounded-lg text-xs font-bold uppercase">
                            {{ $admin->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $admin->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $admin->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button class="p-2 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit"></i></button>
                            @if($admin->id != auth()->id())
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-user-minus"></i></button>
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
