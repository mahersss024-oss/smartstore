<div class="w-full">
    <x-page-header
        title="Links"
        description="Manage your link recommendations"
    >
        <flux:button icon="plus" wire:click="create" variant="primary">Add Link</flux:button>
    </x-page-header>

    @if($links->isNotEmpty())
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>URL</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Created</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($links as $link)
                    <flux:table.row>
                        <flux:table.cell>{{ $link->title }}</flux:table.cell>
                        <flux:table.cell>
                            <a href="{{ $link->url }}" target="_blank" class="hover:text-accent hover:underline">
                                {{ Str::limit($link->url, 50) }}
                            </a>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$link->is_active ? 'lime' : 'gray'">
                                {{ $link->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $link->created_at->format('d M, Y H:i:s') }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" class="h-8 w-8 p-0">
                                    <flux:icon icon="ellipsis-horizontal" variant="mini"/>
                                </flux:button>

                                <flux:menu>
                                    <flux:menu.item
                                        icon="pencil-square"
                                        wire:click="editLink({{ $link->id }})"
                                    >
                                        Edit
                                    </flux:menu.item>

                                    <flux:menu.item
                                        icon="{{ $link->is_active ? 'eye-slash' : 'eye' }}"
                                        wire:click="toggleActive({{ $link->id }})"
                                    >
                                        {{ $link->is_active ? 'Deactivate' : 'Activate' }}
                                    </flux:menu.item>

                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        wire:click="delete({{ $link->id }})"
                                        wire:confirm="Are you sure you want to delete this link?"
                                    >
                                        Delete
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        @if($links->hasPages())
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                {{ $links->links() }}
            </div>
        @endif
    @else
        <flux:callout icon="exclamation-circle" color="zinc">
            <flux:callout.heading class="inline">You have not added any links yet. Click the
                <button class="font-semibold underline hover:cursor-pointer" wire:click="create">Add Link</button>
                to create your first link and start curating your links collection.
            </flux:callout.heading>
        </flux:callout>
    @endif

    <!-- Link Modal -->
    <flux:modal wire:model.self="showLinkModal">
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $form->link ? 'Edit Link' : 'Add New Link' }}</flux:heading>
                <flux:text class="mt-2">Add a new link to your curated collection</flux:text>
            </div>

            <!-- Title -->
            <flux:field>
                <flux:label badge="Required">Title</flux:label>
                <flux:input
                    wire:model="form.title"
                    required="true"
                    placeholder="Enter link title"
                />
                <flux:error name="form.title"/>
            </flux:field>

            <!-- URL -->
            <flux:field>
                <flux:label badge="Required">URL</flux:label>
                <flux:input
                    wire:model="form.url"
                    type="url"
                    required="true"
                    placeholder="https://example.com"
                />
                <flux:error name="form.url"/>
            </flux:field>

            <!-- Description -->
            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea
                    wire:model="form.description"
                    placeholder="Enter link description"
                    rows="3"
                />
                <flux:error name="form.description"/>
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

                <flux:button type="submit" variant="primary">
                    {{ $form->link ? 'Update Link' : 'Create Link' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
