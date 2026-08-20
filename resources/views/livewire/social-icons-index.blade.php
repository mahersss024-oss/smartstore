<div class="w-full">
    <x-page-header
        title="Social Icons"
        description="Manage your social media profiles"
    >
        <flux:button icon="plus" wire:click="create" variant="primary">Add Social Icon</flux:button>
    </x-page-header>

    @if($socialIcons->isNotEmpty())
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Platform</flux:table.column>
                <flux:table.column>URL/UserName</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Created</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($socialIcons as $socialIcon)
                    <flux:table.row>
                        <flux:table.cell>{{ $socialIcon->platform->label() }}</flux:table.cell>
                        <flux:table.cell>
                            <a href="{{ $socialIcon->url }}" target="_blank" class="hover:text-accent hover:underline">
                                {{ Str::limit($socialIcon->url, 50) }}
                            </a>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$socialIcon->is_active ? 'lime' : 'gray'">
                                {{ $socialIcon->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $socialIcon->created_at->format('d M, Y H:i:s') }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" class="h-8 w-8 p-0">
                                    <flux:icon icon="ellipsis-horizontal" variant="mini" />
                                </flux:button>

                                <flux:menu>
                                    <flux:menu.item
                                        icon="pencil-square"
                                        wire:click="edit({{ $socialIcon->id }})"
                                    >
                                        Edit
                                    </flux:menu.item>

                                    <flux:menu.item
                                        icon="{{ $socialIcon->is_active ? 'eye-slash' : 'eye' }}"
                                        wire:click="toggleActive({{ $socialIcon->id }})"
                                    >
                                        {{ $socialIcon->is_active ? 'Deactivate' : 'Activate' }}
                                    </flux:menu.item>

                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        wire:click="delete({{ $socialIcon->id }})"
                                        wire:confirm="Are you sure you want to delete this social icon?"
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
    @else
        <flux:callout icon="exclamation-circle" color="zinc">
            <flux:callout.heading class="inline">You have not added any social icons yet. Click the <button class="font-semibold underline hover:cursor-pointer" wire:click="create">Add Social Icon</button> to add your first social icon in your profile.</flux:callout.heading>
        </flux:callout>
    @endif

    <!-- Social Icon Modal -->
    <flux:modal wire:model.self="showSocialIconModal">
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $form->socialIcon ? 'Edit Social Icon' : 'Add New Social Icon' }}</flux:heading>
                <flux:text class="mt-2">Add a new social media profile to your collection</flux:text>
            </div>

            <!-- Platform -->
            <flux:field>
                <flux:label badge="Required">Platform</flux:label>
                <flux:select
                    wire:model.live="form.platform"
                    required="true"
                    :disabled="$form->socialIcon"
                >
                    <option value="">Select Platform</option>
                    @foreach($availablePlatforms as $platform)
                        <option
                            value="{{ $platform->value }}"
                            @selected($form->platform === $platform)
                        >{{ $platform->label() }}</option>
                    @endforeach
                </flux:select>
                <flux:error name="form.platform" />
            </flux:field>

            <!-- URL -->
            <flux:field>
                <flux:label badge="Required">URL</flux:label>
                <flux:input
                    wire:model="form.url"
                    required="true"
                    placeholder="{{ $platformExample }}"
                />
                <flux:description class="!mt-0.5">Example: {{ $platformExample }}</flux:description>
                <flux:error name="form.url" />
            </flux:field>

            <!-- Status -->
            <flux:field>
                <div class="flex items-center gap-2">
                    <flux:switch wire:model="form.is_active" />
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
                    {{ $form->socialIcon ? 'Update Social Icon' : 'Create Social Icon' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
