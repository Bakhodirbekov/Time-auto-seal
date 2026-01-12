@extends('layouts.admin')

@section('page_title', 'Sozlamalar')

@section('content')
<div class="max-w-4xl bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <h3 class="text-xl font-bold text-gray-800 mb-8 border-b pb-4">Tizim sozlamalari</h3>
    
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            @foreach($settings as $setting)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700">{{ $setting->description ?? $setting->key }}</label>
                    <span class="text-xs text-gray-400">{{ $setting->key }}</span>
                </div>
                <div class="md:col-span-2">
                    @if($setting->type == 'boolean')
                        <select name="settings[{{ $setting->key }}]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                            <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Ha / Yoqilgan</option>
                            <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Yo'q / O'chirilgan</option>
                        </select>
                    @elseif($setting->type == 'integer')
                        <input type="number" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                    @else
                        <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-10 pt-6 border-t border-gray-100">
            <button type="submit" class="bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-secondary transition shadow-lg">Sozlamalarni saqlash</button>
        </div>
    </form>
</div>
@endsection
