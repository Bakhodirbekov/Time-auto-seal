@extends('layouts.admin')

@section('page_title', 'Foydalanuvchilar')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Barcha foydalanuvchilar</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">Foydalanuvchi</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Telefon</th>
                    <th class="px-6 py-4">Sana</th>
                    <th class="px-6 py-4">Holati</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" class="w-8 h-8 rounded-full">
                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4">
                        @if($user->is_blocked)
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Bloklangan</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Aktiv</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            @if($user->is_blocked)
                                <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded" title="Blokdan chiqarish"><i class="fas fa-unlock"></i></button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.block', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 text-orange-600 hover:bg-orange-50 rounded" title="Bloklash"><i class="fas fa-lock"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection
