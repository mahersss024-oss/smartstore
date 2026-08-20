@push('scripts')
    @paddleJS
@endpush

<div x-data="{ billingCycle: 'monthly' }" x-cloak class="min-h-screen bg-gradient-to-b from-white via-zinc-50/50 to-zinc-100 dark:from-zinc-900 dark:via-zinc-800/50 dark:to-zinc-800">
    <div class="container mx-auto px-4 md:px-6 py-20">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit mb-4">
                    Simple Pricing
                </div>
                <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground mb-4">
                    Pricing
                </h1>
                <p class="text-muted-foreground text-lg max-w-2xl mx-auto mb-8">
                    Choose the plan that works for you
                </p>

                <!-- Billing Toggle -->
                <div class="flex items-center justify-center mb-12">
                    <div class="flex items-center rounded-lg border p-1 bg-muted">
                        <button
                            @click="billingCycle = 'monthly'"
                            :class="billingCycle === 'monthly' ? 'bg-accent text-accent-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-colors"
                        >
                            Monthly
                        </button>
                        <button
                            @click="billingCycle = 'yearly'"
                            :class="billingCycle === 'yearly' ? 'bg-accent text-accent-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-colors"
                        >
                            Yearly
                            <flux:badge variant="solid" color="emerald" size="sm" class="ml-1.5 rounded-full! px-2! py-0.5!">
                                Save 16%
                            </flux:badge>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid gap-8 lg:grid-cols-2 lg:gap-12 max-w-4xl mx-auto">
                <!-- Free Plan -->
                <div class="relative rounded-xl border bg-card p-8 shadow-sm">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-foreground mb-2">Free</h3>
                        <div class="flex items-baseline">
                            <span class="text-4xl font-bold text-foreground">$0</span>
                            <span class="text-muted-foreground ml-1">/month</span>
                        </div>
                        <p class="text-muted-foreground text-sm mt-2">Perfect for getting started</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-accent mt-0.5 flex-shrink-0" />
                            <span class="text-muted-foreground">All social icons</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-accent mt-0.5 flex-shrink-0" />
                            <span class="text-muted-foreground">30 products</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-accent mt-0.5 flex-shrink-0" />
                            <span class="text-muted-foreground">10 links</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-accent mt-0.5 flex-shrink-0" />
                            <span class="text-muted-foreground">Email support</span>
                        </div>
                    </div>

                    <flux:button href="{{ route('register') }}" class="w-full">
                        Get Started Free
                    </flux:button>
                </div>

                <!-- Pro Plan -->
                <div class="relative rounded-xl border bg-card p-8 shadow-sm ring-2 ring-accent/20">
                    <div class="mb-6">
                        <div class="mb-2 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-foreground">Pro</h3>
                            <flux:badge color="lime" size="sm" class="ml-2">Most Popular</flux:badge>
                        </div>
                        <div class="flex items-baseline">
                            <span x-show="billingCycle === 'monthly'" class="text-4xl font-bold text-foreground">$3</span>
                            <span x-show="billingCycle === 'yearly'" class="text-4xl font-bold text-foreground">$2.5</span>
                            <span class="text-muted-foreground ml-1">/month</span>
                        </div>
                        <p class="text-muted-foreground text-sm mt-2">Everything in Free, plus</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" />
                            <span class="text-foreground font-medium">Custom domain connection</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" />
                            <span class="text-muted-foreground">Unlimited products</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" />
                            <span class="text-muted-foreground">Unlimited links</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <flux:icon.check variant="solid" class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" />
                            <span class="text-muted-foreground">Priority support</span>
                        </div>
                    </div>

                    @if(auth()->check() && auth()->user()->subscribed())
                        <flux:button
                            href="{{ auth()->user()->getCustomerPortalUrl() }}"
                            target="_blank"
                            variant="primary"
                            class="w-full"
                        >
                            Manage Subscription
                        </flux:button>
                    @elseif(auth()->check())
                        <div>
                            <div x-show="billingCycle === 'monthly'">
                                <x-paddle-button :checkout="$pro_monthly_checkout">
                                    <flux:button variant="primary" class="w-full">
                                        Get Pro Monthly
                                    </flux:button>
                                </x-paddle-button>
                            </div>
                            <div x-show="billingCycle === 'yearly'">
                                <x-paddle-button :checkout="$pro_yearly_checkout">
                                    <flux:button variant="primary" class="w-full">
                                        Get Pro Yearly
                                    </flux:button>
                                </x-paddle-button>
                            </div>
                        </div>
                    @else
                        <div>
                            <flux:button x-show="billingCycle === 'monthly'" wire:click="login" variant="primary" class="w-full">
                                Get Pro Monthly
                            </flux:button>
                            <flux:button x-show="billingCycle === 'yearly'" wire:click="login" variant="primary" class="w-full">
                                Get Pro Yearly
                            </flux:button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- FAQ or Additional Info -->
            <div class="text-center mt-16">
                <h2 class="text-2xl font-bold text-foreground mb-4">Have questions?</h2>
                <p class="text-muted-foreground mb-6">
                    We're here to help you choose the right plan for your needs.
                </p>
                <flux:button
                    href="{{ route('pages.contact-us') }}"
                    variant="outline"
                >
                    Contact Support
                </flux:button>
            </div>
        </div>
    </div>
</div>
