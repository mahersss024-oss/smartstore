@props([
    'class' => '',
])

<p {{ $attributes->merge(['class' => 'mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-2 ' . $class]) }}>
    {{ $slot }}
</p> 