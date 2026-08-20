<div class="w-full">
    <x-page-header
        title="Products"
        description="Manage your product recommendations"
    >
        <flux:button icon="plus" wire:click="create" variant="primary">Add Product</flux:button>
    </x-page-header>

    <div class="space-y-6">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 lg:gap-4">
                @foreach($products as $product)
                    <x-web.product-card
                        :product="$product"
                    >
                        <x-slot:actions>
                            <flux:dropdown class="absolute top-3 left-3 sm:top-4 sm:left-4">
                                <flux:button size="sm" class="h-8 w-8 p-0 hover:bg-zinc-100! dark:hover:bg-zinc-700/70! hover:border-zinc-400! dark:hover:border-zinc-500!">
                                    <flux:icon icon="ellipsis-vertical" variant="mini"/>
                                </flux:button>

                                <flux:menu>
                                    <flux:menu.item
                                        icon="eye"
                                        @click="$wire.dispatch('modal-show', { name: 'view-product-{{ $product->id }}' })"
                                    >
                                        View
                                    </flux:menu.item>

                                    <flux:menu.item
                                        icon="pencil-square"
                                        wire:click="edit({{ $product->id }})"
                                    >
                                        Edit
                                    </flux:menu.item>

                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Are you sure you want to delete this product?"
                                    >
                                        Delete
                                    </flux:menu.item>

                                    @if ($product->affiliate_url)
                                        <flux:menu.item
                                            icon="arrow-top-right-on-square"
                                            as="a"
                                            href="{{ $product->affiliate_url }}"
                                            target="_blank"
                                        >
                                            Visit Link
                                        </flux:menu.item>
                                    @endif
                                </flux:menu>
                            </flux:dropdown>
                        </x-slot:actions>
                    </x-web.product-card>
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <flux:callout icon="exclamation-circle" color="zinc">
                <flux:callout.heading class="inline">You have not added any products yet. Click the <button class="font-semibold underline hover:cursor-pointer" wire:click="create" >Add Product</button> to create your first product and start curating your products collection.</flux:callout.heading>
            </flux:callout>
        @endif
    </div>

    <!-- Product Modal -->
    <flux:modal wire:model.self="showProductModal">
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $form->product ? 'Edit Product' : 'Add New Product' }}</flux:heading>
                <flux:text class="mt-2">Add a new product to your curated collection</flux:text>
            </div>

            <!-- Name -->
            <flux:field>
                <flux:label badge="Required">Name</flux:label>

                <flux:input
                    wire:model="form.name"
                    required
                    placeholder="Enter product name"
                />

                <flux:error name="form.name"/>
            </flux:field>

            <!-- Description -->
            <flux:field>
                <flux:label>Description</flux:label>

                <flux:textarea
                    wire:model="form.description"
                    rows="4"
                    placeholder="Enter product description"
                />

                <flux:error name="form.description"/>
            </flux:field>

            <!-- Product Image -->
            <flux:field>
                <flux:label>Image</flux:label>

                <div>
                    <flux:input
                        type="file"
                        wire:model="form.media"
                        accept="image/*"
                    />

                    <flux:description class="mt-2">Use a square image for better view.</flux:description>
                </div>

                <flux:error name="form.media"/>

                @if($form->media)
                    <div class="mt-4 flex gap-4">
                        <div class="relative bg-gray-300 rounded-lg">
                            <img src="{{ $form->media->temporaryUrl() }}" class="h-40 w-40 object-contain" alt="media"/>
                        </div>
                    </div>
                @endif

                @if($form->media_preview)
                    <div class="mt-4 flex gap-4">
                        <div class="relative bg-gray-300 rounded-lg">
                            <img src="{{ $form->media_preview->getUrl() }}" class="h-40 w-40 object-contain"
                                 alt="{{ $form->media_preview->name }}"/>
                            <button type="button" wire:click="deleteMedia({{ $form->media_preview->id }})"
                                    class="absolute top-2 right-2 bg-white rounded-full shadow-sm hover:bg-gray-100">
                                <flux:icon name="x-mark" class="w-5 h-5 text-gray-600"/>
                            </button>
                        </div>
                    </div>
                @endif
            </flux:field>

            <!-- Affiliate URL -->
            <flux:field>
                <flux:label badge="Required">Affiliate URL</flux:label>

                <flux:input
                    wire:model="form.affiliate_url"
                    type="url"
                    required
                    placeholder="https://example.com"
                />

                <flux:error name="form.affiliate_url"/>
            </flux:field>

            <!-- Status -->
            <flux:field>
                <div class="flex items-center gap-2">
                    <flux:switch wire:model="form.is_active"/>
                    <flux:label>Active</flux:label>
                </div>
            </flux:field>

            <div class="flex justify-end space-x-2">
                <flux:modal.close>
                    <flux:button variant="outline">
                        Cancel
                    </flux:button>
                </flux:modal.close>

                <flux:button wire:click="save" variant="primary">
                    {{ $form->product ? 'Update Product' : 'Create Product' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
