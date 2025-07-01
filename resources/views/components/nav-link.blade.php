@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 pt-1 border-b-2 border-orange-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-md font-medium leading-5 text-black dark:text-gray-400 hover:text-white hover:bg-orange-600 dark:hover:text-gray-300 hover:border-white dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
