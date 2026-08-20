<div class="mt-6 grid grid-cols-2 gap-2 sm:grid-cols-2 lg:grid-cols-4 lg:gap-4">
    @foreach($categories as $category)
        <a
            href="{{ route('store', ['category' => $category->id]) }}"
            wire:navigate
            class="group relative e-com-card flex items-center space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 hover:border-gray-200"
        >
            <img
                src="{{ $category->getFirstMediaUrl() }}"
                alt="{{ $category->name }}"
                class="w-12 h-12 rounded-full object-cover object-center"
            >
            <div class="flex-1 truncate">
                <p class="font-medium text-gray-600 dark:text-gray-300">{{ $category->name }}</p>
                <p>{{ $category->products_count }} {{ Str::plural(__('Product'), $category->products_count) }}</p>
            </div>
        </a>
    @endforeach
</div>
