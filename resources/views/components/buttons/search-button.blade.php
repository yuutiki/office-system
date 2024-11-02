@props(['text' => '検索'])

<button {{ $attributes->merge([
    'type' => 'submit',
    'id' => 'search-button',
    'class' => 'p-2.5 w-full md:ms-2 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
]) }}>
    <div class="flex items-center">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
        <span class="md:hidden mx-auto">{{ $text }}</span>
    </div>
</button>


{{-- 使用例 --}}

{{-- 基本的な使用方法 --}}
{{-- <x-buttons.search-button /> --}}

{{-- 追加の属性を渡す場合 --}}
{{-- <x-buttons.search-button 
    id="search-button" 
    form="search_form" 
    tabindex=""
/> --}}

{{-- テキストを変更する場合 --}}
{{-- <x-buttons.search-button text="検索する" /> --}}

{{-- クラスを追加/上書きする場合 --}}
{{-- <x-buttons.search-button class="custom-class" /> --}}