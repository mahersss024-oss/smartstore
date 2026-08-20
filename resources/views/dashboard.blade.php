<div>
    <x-page-header
        title="Dashboard"
        description="Welcome to your dashboard!"
    ></x-page-header>

    <div class="space-y-6">
        <!-- Subscription Plans -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Free Plan Card -->
            <flux:card class="p-5 flex flex-col justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <flux:heading size="md" class="font-semibold">Free Plan</flux:heading>
                        @if(! auth()->user()->subscribed())
                            <flux:badge size="xs" variant="pill" color="green">Active</flux:badge>
                        @endif
                    </div>
                    <flux:text class="text-sm leading-relaxed">
                        Limited products & links, Unlimited social icons, Basic analytics and more.
                    </flux:text>
                </div>
            </flux:card>

            <!-- Pro Plan Card -->
            <flux:card class="p-5 flex flex-col justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <flux:heading size="md" class="font-semibold">Pro</flux:heading>
                        @if(auth()->user()->subscribed())
                            <flux:badge size="xs" variant="pill" color="green">Active</flux:badge>
                        @endif
                    </div>
                    <flux:text class="text-sm leading-relaxed">
                        Unlimited products & links, custom domain, priority support and more.
                    </flux:text>
                </div>
                @if(auth()->user()->subscribed())
                    <flux:button
                        wire:click="goToCustomerPortalUrl"
                        target="_blank"
                        size="sm"
                        variant="outline"
                        class="w-fit"
                    >
                        Manage Subscription
                    </flux:button>
                @else
                    <flux:button
                        href="{{ route('pages.pricing') }}"
                        variant="primary"
                        size="sm"
                        class="w-fit"
                    >
                        Upgrade to Pro
                    </flux:button>
                @endif
            </flux:card>

            <!-- Additional Tier Placeholder (future) -->
            <flux:card class="p-5 flex flex-col justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <flux:heading size="md" class="font-semibold">Pro+</flux:heading>
                    </div>
                    <flux:text class="text-sm leading-relaxed">
                        Advanced customization, product badges and more.
                    </flux:text>
                </div>
                <flux:button size="sm" class="w-fit" disabled>Coming Soon</flux:button>
            </flux:card>
        </div>
    </div>
</div>
