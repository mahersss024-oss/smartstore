@props([
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden ' . $class]) }}>
    {{ $slot }}
</div> 