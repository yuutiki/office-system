@props([
    'text' => 'リセット',
    'form' => 'search_form'
])

<button {{ $attributes->merge([
    'type' => 'button',
    'id' => 'clear',
    'value' => 'reset',
    'form' => $form,
    'class' => 'p-2.5 w-full ms-2 text-sm font-medium text-white bg-gray-500 rounded border border-gray-500 dark:border-gray-500 hover:bg-gray-600 focus:ring-2 focus:outline-none dark:bg-gray-500 dark:hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
]) }}>
    <div class="flex items-center">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
        </svg>
        <span class="md:hidden mx-auto">{{ $text }}</span>
    </div>
</button>