<div class="flex flex-col min-h-screen" x-data="{ activeView: 'store' }" x-cloak>
    <main class="flex-1 py-10 px-4 md:px6">
        <!-- Profile Details -->
        <div class="max-w-xl mx-auto text-center space-y-2">
            <div class="flex justify-center mb-3">
                <div class="relative">
                    <div class="absolute rounded-full bg-gradient-to-r from-accent/20 to-accent/40"></div>
                    @if($user->hasMedia('default'))
                        <img
                            src="{{ $user->getFirstMediaUrl('default') }}"
                            alt="{{ ucfirst($user->name) }}'s Profile"
                            class="w-[120px] h-[120px] object-cover relative rounded-full border-4 border-accent shadow-xl"
                        />
                    @else
                        <div class="w-[120px] h-[120px] flex items-center justify-center bg-zinc-200 relative rounded-full border-4 border-accent shadow-xl">
                            <flux:icon name="user" class="w-10 h-10 text-gray-400"/>
                        </div>
                    @endif
                </div>
            </div>

            @if($user->display_name || $user->bio)
                <div>
                    @if($user->display_name)
                        <flux:heading size="xl">
                            {{ $user->display_name }}
                        </flux:heading>
                    @endif

                    @if($user->bio)
                        <flux:text size="lg">{{ $user->bio }}</flux:text>
                    @endif
                </div>
            @endif

            <!-- Social Media Icons -->
            <x-web.socail-icons :social-icons="$socialIcons"/>
        </div>

        <!-- Toggle Button -->
        <div class="flex justify-center my-6">
            <div class="inline-flex items-center p-1 rounded-full border bg-muted/30">
                <button
                    @click="activeView = 'store'"
                    :class="activeView === 'store' ? 'bg-accent text-accent-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'"
                    class="flex items-center justify-center px-6 py-2 rounded-full text-sm font-medium transition-all duration-200"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="mr-2 h-4 w-4"
                    >
                        <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                        <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                        <path d="M12 3v6"></path>
                    </svg>
                    Store
                </button>
                <button
                    @click="activeView = 'links'"
                    :class="activeView === 'links' ? 'bg-accent text-accent-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'"
                    class="flex items-center justify-center px-6 py-2 rounded-full text-sm font-medium transition-all duration-200"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="mr-2 h-4 w-4"
                    >
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                        <path d="M2 12h20"></path>
                    </svg>
                    Links
                </button>
            </div>
        </div>

        <!-- Store Section -->
        <div
            x-show="activeView === 'store'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="max-w-3xl mx-auto"
        >
            @if($products->count() > 0 || $productSearch)
                <flux:input
                    wire:model.live.debounce.300ms="productSearch"
                    icon="magnifying-glass"
                    class="mb-4 rounded-full!"
                    :clearable="true"
                    placeholder="Search products..."
                />

                <div class="grid grid-cols-2 !gap-3 sm:grid-cols-3 !sm:gap-4">
                    @foreach($products as $product)
                        <x-web.product-card
                            :product="$product"
                        />
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif
            @endif

            @if($products->count() === 0)
                <div class="p-4 flex justify-center text-muted-foreground">
                    <svg class="h-6 w-6 me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    >
                        <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"></path>
                        <line x1="12" x2="12" y1="8" y2="12"></line>
                        <line x1="12" x2="12" y1="16" y2="16"></line>
                    </svg>
                    <h3 class="text-lg font-semibold">No products found</h3>
                </div>
            @endif
        </div>

        <!-- Links Section -->
        <div
            x-show="activeView === 'links'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="max-w-3xl mx-auto space-y-3 "
        >
            @if($links->count() > 0 || $linkSearch)
                <flux:input
                    wire:model.live.debounce.300ms="linkSearch"
                    icon="magnifying-glass"
                    class="mb-4"
                    :clearable="true"
                    placeholder="Search links..."
                />

                @foreach($links as $link)
                    <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="block">
                        <div class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-accent/5 to-accent/10  border border-accent/50 transition-all hover:border-zinc-500 hover:bg-accent/20 backdrop-blur-sm">
                            <div class="relative p-4 flex items-center gap-4">
                                <div class="rounded-full bg-accent/10 p-3 flex-shrink-0">
                                    <flux:icon name="globe-alt" class="h-5 w-5 text-accent"/>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <flux:heading size="lg">{{ $link->title }}</flux:heading>
                                    <flux:text>{{ $link->description }}</flux:text>
                                </div>
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="h-4 w-4 text-accent">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" x2="21" y1="14" y2="3"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                @if($links->hasPages())
                    <div class="mt-6">
                        {{ $links->links() }}
                    </div>
                @endif
            @endif

            @if($links->count() === 0)
                <div class="p-4 flex justify-center text-muted-foreground">
                    <svg class="h-6 w-6 me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    >
                        <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"></path>
                        <line x1="12" x2="12" y1="8" y2="12"></line>
                        <line x1="12" x2="12" y1="16" y2="16"></line>
                    </svg>
                    <h3 class="text-lg font-semibold">No Links found</h3>
                </div>
            @endif
        </div>
    </main>

    <footer class="pb-6 text-center">
        <a
            href="{{ config('app.url') }}"
            class="text-sm text-muted-foreground hover:text-primary transition-colors flex items-center justify-center gap-1"
        >
            <span>Powered by</span>
            <span class="font-semibold">ShelfCurator</span>
        </a>
    </footer>
</div>
