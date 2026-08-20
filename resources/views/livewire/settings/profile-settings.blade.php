<section class="w-full">
    <x-page-header
        :title="__('Settings')"
        :description="__('Manage your profile settings')"
    />

    <x-settings.layout
        :heading="__('Profile Settings')"
        :subheading="__('Customize how your profile')"
    >
        @if (session('message'))
            <flux:alert type="success" class="mb-4">{{ session('message') }}</flux:alert>
        @endif
        @if (session('error'))
            <flux:alert type="danger" class="mb-4">{{ session('error') }}</flux:alert>
        @endif

        <form wire:submit="save">
            <!-- Username -->
            <flux:field class="mt-4">
                <flux:label>Username</flux:label>
                <flux:input wire:model.live.debounce.300ms="username" placeholder="username_example"/>
                <flux:text size="sm" class="text-gray-500">
                    Only letters (a-z), numbers (0-9), and underscores (_) are allowed.
                </flux:text>
                <flux:error name="username"/>
            </flux:field>

            <!-- Store Name -->
            <flux:field class="mt-4">
                <flux:label>Name</flux:label>
                <flux:input wire:model="name"/>
                <flux:error name="name"/>
            </flux:field>

            <!-- Store Description -->
            <flux:field class="mt-4">
                <flux:label>Bio</flux:label>
                <flux:textarea wire:model="description" rows="4"/>
                <flux:error name="description"/>
            </flux:field>

            <!-- Store Logo -->
            <flux:field class="mt-4">
                <flux:label>Logo</flux:label>
                <div class="flex items-start gap-4">
                    @if($logo)
                        <img src="{{ $logo->temporaryUrl() }}" class="h-16 w-16 rounded-full object-cover"
                             alt="Logo preview"/>
                    @endif

                    @if($logo_preview)
                        <div class="relative bg-gray-300 rounded-full">
                            <img src="{{ $logo_preview->getUrl() }}" class="h-16 w-16 rounded-full object-cover"
                                 alt="Current logo"/>
                            <button
                                type="button"
                                wire:click="deleteLogo"
                                class="absolute top-0 right-0 bg-white rounded-full shadow-sm hover:bg-gray-100"
                            >
                                <flux:icon name="x-mark" class="w-5 h-5 text-gray-600"/>
                            </button>
                        </div>
                    @elseif(!$logo)
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            <flux:icon name="user" class="w-8 h-8 text-gray-400"/>
                        </div>
                    @endif

                    <div class="space-y-2">
                        <flux:input
                            type="file"
                            wire:model="logo"
                            accept="image/*"
                        />
                        <flux:error name="logo"/>
                        <flux:text size="sm" class="text-gray-500">
                            Max file size: 3MB.
                        </flux:text>
                    </div>
                </div>
            </flux:field>

            <flux:button variant="primary" type="submit" class="mt-6">Save Profile Settings</flux:button>
        </form>
    </x-settings.layout>
</section>
