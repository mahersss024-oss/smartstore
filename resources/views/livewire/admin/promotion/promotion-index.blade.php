<div class="w-full">
    <x-page-header
        title="Promotions"
        description="Manage your promotions recommendations"
    >
        <flux:button icon="plus" wire:click="create" variant="primary">Send Invite</flux:button>
    </x-page-header>

    <flux:modal wire:model.self="showPromotionModal">
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">Send Invite</flux:heading>
                <flux:text class="mt-2">Send user invite on platform</flux:text>
            </div>

            <!-- User Name -->
            <flux:field>
                <flux:label badge="Required">User Name</flux:label>
                <flux:input
                    wire:model="name"
                    required="true"
                    placeholder="Enter user name"
                />
                <flux:error name="name"/>
            </flux:field>

            <!-- User Email -->
            <flux:field>
                <flux:label badge="Required">User Email</flux:label>
                <flux:input
                    wire:model="email"
                    type="email"
                    required="true"
                    placeholder="hi@example.com"
                />
                <flux:error name="email"/>
            </flux:field>

            <div class="flex justify-end space-x-2">
                <flux:modal.close>
                    <flux:button variant="outline">
                        Cancel
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">
                    Send
                </flux:button>
            </div>
        </form>
    </flux:modal>

</div>
