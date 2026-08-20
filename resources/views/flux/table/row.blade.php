@props([
    'key' => null,
])

@php
$classes = Flux::classes()
    ->add('hover:bg-zinc-50 dark:hover:bg-zinc-800/50');
@endphp

<tr {{ $attributes->class($classes) }} @if($key) wire:key="{{ $key }}" @endif>
    {{ $slot }}
</tr> 