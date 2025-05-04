<!-- resources/views/client/checkbox-options/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            チェックボックス編集: {{ $clientContactCheckboxOption->label }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('client-contacts.checkbox-options.update', $clientContactCheckboxOption) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">名前 (英数字)</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $clientContactCheckboxOption->name) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <small class="text-gray-500">例: is_sample_receiver</small>
                            @error('name')
                                <div class="text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="label" class="block text-sm font-medium text-gray-700">ラベル (表示名)</label>
                            <input type="text" name="label" id="label" value="{{ old('label', $clientContactCheckboxOption->label) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <small class="text-gray-500">例: サンプル送付先</small>
                            @error('label')
                                <div class="text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                       {{ old('is_active', $clientContactCheckboxOption->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">有効</label>
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <a href="{{ route('client-contacts.checkbox-options.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                キャンセル
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>