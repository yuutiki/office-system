<!-- resources/views/components/buttons/add-button-drawer.blade.php -->
@props([
    'gate' => 'storeUpdate_clients',
    'text' => __('Add'),
    'icon' => true,
    'onclick' => null  // onclick属性を追加
])

@php
    $canStore = Gate::allows($gate);
    $buttonClasses = 'flex items-center pl-2 sm:px-4 py-2 text-sm font-medium text-white rounded focus:outline-none';
    $buttonClasses .= $canStore
        ? ' hover:bg-[#313a48] bg-[#364050] focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
        : ' hover:bg-[#313a48] bg-[#364050] focus:ring-2 focus:ring-blue-300 dark:bg-gray-600 dark:hover:bg-gray-700 cursor-not-allowed';
@endphp

<button 
    type="button" 
    class="{{ $buttonClasses }}"
    id="add-button"
    data-tooltip-target="tooltip-add-button"
    data-tooltip-placement="bottom"
    @if($onclick) onclick="{{ $onclick }}" @endif
    @if(!$canStore) disabled @endif
    {{ $attributes->except(['class', 'onclick']) }}
>
    @if($icon)
        <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
        </svg>
    @endif
    <div class="hidden sm:block">{{ $slot->isEmpty() ? $text : $slot }}</div>
</button>

<div id="tooltip-add-button" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs opacity-0 tooltip dark:bg-gray-600">
    Ctrl + A
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>