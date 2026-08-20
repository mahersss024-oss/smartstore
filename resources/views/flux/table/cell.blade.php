@props([
    'align' => 'start',
    'variant' => 'default',
])

@php
$alignClass = match ($align) {
    'start' => 'text-left',
    'center' => 'text-center',
    'end' => 'text-right',
    default => 'text-left',
};

$variantClass = match ($variant) {
    'strong' => 'font-medium',
    default => '',
};

$classes = Flux::classes()
    ->add('px-4 py-3')
    ->add($alignClass)
    ->add($variantClass);
@endphp

<td {{ $attributes->class($classes) }}>
    {{ $slot }}
</td> 