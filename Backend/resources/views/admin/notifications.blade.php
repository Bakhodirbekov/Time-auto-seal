@extends('layouts.admin')

@section('page_title', 'Bildirishnomalar')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Tizim bildirishnomalari</h3>
        <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-secondary transition">Yangi yuborish</button>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($notifications as $notification)
        <div class="p-6 hover:bg-gray-50 transition">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $notification->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                        <div class="flex items-center space-x-4 mt-3">
                            <span class="text-xs text-gray-400"><i class="fas fa-user mr-1"></i> {{ $notification->user->name ?? 'Tizim' }}</span>
                            <span class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="p-2 text-gray-400 hover:text-red-600 rounded"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        </div>
        @empty
        <div class="p-10 text-center text-gray-500">Bildirishnomalar topilmadi</div>
        @endforelse
    </div>
    <div class="p-4 border-t border-gray-100">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
