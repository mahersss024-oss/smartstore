@props([
    'align' => 'right',
    'width' => '48',
])

@php
$alignmentClasses = match ($align) {
    'left' => 'origin-top-left left-0',
    'right' => 'origin-top-right right-0',
    'top' => 'origin-top',
    default => 'origin-top-right right-0',
};

$width = match ($width) {
    '48' => 'w-48',
    '56' => 'w-56',
    '64' => 'w-64',
    default => 'w-48',
};
@endphp

<div x-data="{ open: false }" @click.away="open = false" @keydown.escape.window="open = false" class="relative">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
         style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            {{ $content }}
        </div>
    </div>
</div> 