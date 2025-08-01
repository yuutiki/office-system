@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-indigo-400 dark:border-indigo-600 text-sm leading-5 text-indigo-400 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-transparent text-sm leading-5 text-gray-100 dark:text-gray-400 hover:text-gray-200 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-200 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} tabindex="-1">
    {{ $slot }}
</a>
