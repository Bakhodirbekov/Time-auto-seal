@extends('layouts.admin')

@section('page_title', 'Bannerlar')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Slayder Bannerlari</h3>
            <p class="text-sm text-gray-500">Asosiy sahifadagi slayder rasmlarini boshqarish</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="px-6 py-2.5 bg-accent text-white rounded-xl text-sm hover:bg-orange-600 transition font-bold shadow-lg shadow-accent/20 flex items-center gap-2">
            <i class="fas fa-plus"></i> Yangi banner
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase font-bold tracking-wider">
                    <th class="px-6 py-4">Rasm</th>
                    <th class="px-6 py-4">Sarlavha va Tavsif</th>
                    <th class="px-6 py-4">Tartibi</th>
                    <th class="px-6 py-4">Holati</th>
                    <th class="px-6 py-4 text-right">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($banners as $banner)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="relative w-32 h-16 rounded-lg overflow-hidden border border-gray-100 shadow-sm">
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800 leading-tight">{{ $banner->title ?? 'Sarlavha yo\'q' }}</p>
                        @if($banner->description)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $banner->description }}</p>
                        @endif
                        @if($banner->link)
                            <a href="{{ $banner->link }}" target="_blank" class="text-[10px] text-accent hover:underline mt-1 block font-medium">
                                <i class="fas fa-link mr-1"></i> Havolani ko'rish
                            </a>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold">
                            {{ $banner->order }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($banner->is_active)
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-[10px] font-black uppercase">Faol</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-black uppercase">O'chirilgan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="w-9 h-9 flex items-center justify-center text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition" title="Tahrirlash">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Haqiqatdan ham ushbu bannerni o\'chirmoqchimisiz?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="O'chirish">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-image text-4xl mb-3"></i>
                            <p class="text-lg font-medium">Hech qanday banner topilmadi</p>
                            <a href="{{ route('admin.banners.create') }}" class="mt-4 text-accent hover:underline font-bold text-sm">
                                Birinchi bannerni qo'shish
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
