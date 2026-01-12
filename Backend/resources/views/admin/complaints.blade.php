@extends('layouts.admin')

@section('page_title', 'Shikoyatlar')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Tizimdagi shikoyatlar</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Avtomobil</th>
                    <th class="px-6 py-4">Mavzu</th>
                    <th class="px-6 py-4">Holati</th>
                    <th class="px-6 py-4">Sana</th>
                    <th class="px-6 py-4">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($complaints as $complaint)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $complaint->user->name ?? 'Noma\'lum' }}</div>
                        <div class="text-xs text-gray-500">{{ $complaint->user->email ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $complaint->car->title ?? 'Noma\'lum' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $complaint->subject }}</td>
                    <td class="px-6 py-4">
                        @if($complaint->status == 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Yangi</span>
                        @elseif($complaint->status == 'resolved')
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Yopilgan</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">{{ $complaint->status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $complaint->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            @if($complaint->status == 'pending')
                                <form action="{{ route('admin.complaints.resolve', $complaint->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded" title="Yopish"><i class="fas fa-check"></i></button>
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
        {{ $complaints->links() }}
    </div>
</div>
@endsection
