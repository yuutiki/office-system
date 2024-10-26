<!-- resources/views/components/buttons/add-button.blade.php -->
@props([
    'route',
    'gate' => 'storeUpdate_clients',
    'text' => __('Add'),
    'icon' => true
])

@php
$canStore = Gate::allows($gate);
$buttonClasses = 'flex items-center pl-2 sm:px-4 py-2 text-sm font-medium text-white rounded focus:outline-none';
$buttonClasses .= $canStore
    ? ' bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
    : ' bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-gray-600 dark:hover:bg-gray-700 cursor-not-allowed';
@endphp

<button 
    type="button" 
    onclick="location.href='{{ $route }}'"
    class="{{ $buttonClasses }}"
    @if(!$canStore) disabled @endif
>
    @if($icon)
    <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
    </svg>
    @endif
    <div class="hidden sm:block">{{ $text }}</div>
</button>

{{-- 使い方： <x-buttons.add-button :route="clients.create" permission="storeUpdate_clients" /> --}}


{{-- コンポーネント化しない場合
@can('storeUpdate_clients')
    <button type="button" onclick="location.href='{{ route('clients.create') }}'" class="flex items-center pl-2 sm:px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
        <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
        </svg>
        <div class="hidden sm:block">{{ __('Add') }}</div>
    </button>
@else
    <button type="button" onclick="location.href='{{ route('clients.create') }}'" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-s rounded-e bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-blue-800 cursor-not-allowed" disabled>
        <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
        </svg>
        <div class="hidden sm:block">{{ __('Add') }}</div>
    </button>
@endcan --}}