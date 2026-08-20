@props([
    'align' => 'start',
    'sortable' => false,
    'sorted' => false,
    'direction' => 'asc',
])

@php
$alignClass = match ($align) {
    'start' => 'text-left',
    'center' => 'text-center',
    'end' => 'text-right',
    default => 'text-left',
};

$classes = Flux::classes()
    ->add('px-4 py-3 font-medium')
    ->add($alignClass)
    ->add($sortable ? 'cursor-pointer select-none' : '');
@endphp

<th {{ $attributes->class($classes) }}>
    <div class="flex items-center space-x-1 rtl:space-x-reverse">
        <span>{{ $slot }}</span>
        
        @if($sortable)
            <span class="inline-flex">
                @if($sorted && $direction === 'asc')
                    <flux:icon icon="chevron-up" variant="micro" class="text-zinc-500 dark:text-zinc-400" />
                @elseif($sorted && $direction === 'desc')
                    <flux:icon icon="chevron-down" variant="micro" class="text-zinc-500 dark:text-zinc-400" />
                @else
                    <flux:icon icon="arrows-up-down" variant="micro" class="text-zinc-400 dark:text-zinc-500" />
                @endif
            </span>
        @endif
    </div>
</th> 