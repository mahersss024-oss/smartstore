@props([
    'product' => 'App\Models\Product',
    'actions' => null,
])

<flux:card
    class="flex flex-col group relative p-1.5 sm:p-2.5 h-full group space-y-2 overflow-hidden"
>
    <div
        class="aspect-square w-full overflow-hidden group-hover:opacity-75 group-hover:cursor-pointer"
        @click="$wire.dispatch('modal-show', { name: 'view-product-{{ $product->id }}' })"
    >
        @if($product->hasMedia('default'))
            <img
                src="{{ $product->getFirstMediaUrl() }}"
                alt="{{ $product->name }}"
                class="h-full w-full object-cover rounded-md"
            >
        @else
            <x-placeholder/>
        @endif
    </div>

    <div>
        <flux:heading size="lg" class="truncate">{{ $product->name }}</flux:heading>

        @if($product->description)
            <flux:text class="truncate">{{ $product->description }}</flux:text>
        @endif
    </div>

    <flux:button
        icon="arrow-top-right-on-square"
        variant="primary"
        class="w-full mt-auto mb-0"
        as="a"
        href="{{ $product->affiliate_url }}"
        target="_blank"
    >
        <span>Buy Now</span>
    </flux:button>

    {{ $actions }}

    <!-- view product modal -->
    <flux:modal
        :name="'view-product-'. $product->id"
        :closable="true"
        x-on:close="$wire.dispatch('modal-close', { name: 'view-product-{{ $product->id }}' })"
        class="min-w-xs sm:min-w-lg sm:max-w-xl"
    >
        <flux:heading size="lg" class="font-semibold">{{ $product->name }}</flux:heading>

        @if($product->description)
            <flux:text class="mt-3 whitespace-pre-line">{{ $product->description }}</flux:text>
        @endif

        <flux:button
            icon="arrow-top-right-on-square"
            variant="primary"
            class="mt-4"
            as="a"
            href="{{ $product->affiliate_url }}"
            target="_blank"
        >
            <span>Buy Now</span>
        </flux:button>
    </flux:modal>
</flux:card>
