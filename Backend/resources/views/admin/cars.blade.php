@extends('layouts.admin')

@section('page_title', 'Avtomobillar')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Barcha avtomobillar</h3>
        <div class="flex items-center space-x-4">
            <div class="flex space-x-2">
                <a href="{{ route('admin.cars', ['status' => 'pending']) }}" class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-sm">Kutilayotganlar</a>
                <a href="{{ route('admin.cars', ['status' => 'approved']) }}" class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm">Tasdiqlanganlar</a>
                <a href="{{ route('admin.cars') }}" class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm">Barchasi</a>
            </div>
            <a href="{{ route('admin.cars.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm font-bold hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i> Yangi qo'shish
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">Rasm</th>
                    <th class="px-6 py-4">Sarlavha</th>
                    <th class="px-6 py-4">Narxi</th>
                    <th class="px-6 py-4">Kategoriya</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($cars as $car)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <img src="{{ $car->images->first()->image_url ?? 'https://via.placeholder.com/60x40' }}" class="w-16 h-10 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $car->title }}
                        <div class="text-xs text-gray-500">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">${{ number_format($car->price) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $car->category->name ?? 'Noma\'lum' }}</td>
                    <td class="px-6 py-4">
                        @if($car->status == 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Kutilmoqda</span>
                        @elseif($car->status == 'approved')
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Tasdiqlangan</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs uppercase">{{ $car->status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            @if($car->status == 'pending')
                                <form action="{{ route('admin.cars.approve', $car->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded" title="Tasdiqlash"><i class="fas fa-check"></i></button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.cars.toggle-hot-deal', $car->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $car->is_hot_deal ? 'text-red-600' : 'text-gray-400' }} hover:bg-red-50 rounded" title="Hot Deal"><i class="fas fa-bolt"></i></button>
                            </form>

                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit"></i></a>
                            
                            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="inline" onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        {{ $cars->links() }}
    </div>
</div>
@endsection
