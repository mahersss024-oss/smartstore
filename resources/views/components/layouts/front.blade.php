<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    @stack('styles')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800" x-data="{ showSidebar: false }" :class="{ 'overflow-hidden': showSidebar }">

@if($showHeader ?? true)
    <header
        class="sticky top-0 z-50 w-full border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-zinc-900/60">
        <div class="lg:container mx-auto px-4 md:px-6 flex h-16 items-center justify-between">
            <div class="flex items-center space-x-3">
                <flux:button
                    class="shrink-0 md:hidden w-fit"
                    variant="subtle"
                    square
                    x-data
                    aria-label="{{ __('Toggle sidebar') }}"
                    x-on:click="showSidebar = !showSidebar"
                    x-cloak
                >
                    <flux:icon.bars-3-bottom-left x-show="!showSidebar" class="w-7 h-7"/>
                    <flux:icon.x-mark x-show="showSidebar" class="w-7 h-7"/>
                </flux:button>
                <a href="{{ route('home') }}" class="flex items-center gap-2" wire:navigate.hover>
                    <x-app-logo-icon class="flex size-8"/>
                    <span class="text-xl font-semibold">ShelfCurator</span>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-6">
                <a
                    href="{{ route('home') }}#how-it-works"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                >
                    How It Works
                </a>
                <a
                    href="{{ route('home') }}#features"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                >
                    Features
                </a>
                <a
                    href="{{ route('home') }}#benefits"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                >
                    Benefits
                </a>
                <a
                    href="{{ route('home') }}#testimonials"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                >
                    Testimonials
                </a>
                <a
                    href="{{ route('pages.pricing') }}"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                >
                    Pricing
                </a>
            </nav>
            <div class="flex items-center gap-2">
                @if(auth()->check())
                    <x-profile-menu/>
                @else
                    <button
                        x-data=""
                        x-cloak
                        x-on:click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'"
                        size="sm"
                        variant="ghost"
                        class="p-1.5 rounded-full text-zinc-500 dark:text-white hover:cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-600"
                    >
                        <flux:icon.sun variant="mini" x-show="$flux.appearance == 'dark'"/>
                        <flux:icon.moon variant="mini" x-show="$flux.appearance == 'light'"/>
                    </button>
                    <flux:button href="{{ route('login') }}" wire:navigate.hover variant="primary" size="sm" class="w-full rounded-full!">
                        Log in
                    </flux:button>
                @endif
            </div>
        </div>
    </header>

    <aside
        id="drawer-navigation"
        class="-translate-x-full md:hidden fixed top-0 left-0 z-40 w-full h-dvh overflow-y-auto transition-transform"
        :class="showSidebar ? 'translate-x-0' : '-translate-x-full'"
        aria-label="Sidenav"
    >
        <div class="flex flex-col justify-between py-5 px-3 h-full bg-white dark:bg-zinc-900 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-zinc-900/60">
            <nav class="flex flex-col items-center gap-4 mt-16">
                <a
                    href="{{ route('pages.pricing') }}"
                    class="text-xl font-semibold hover:text-accent transition-colors"
                >
                    Pricing
                </a>
                <a
                    href="{{ route('pages.contact-us') }}"
                    class="text-xl font-semibold hover:text-accent transition-colors"
                    wire:navigate
                >
                    Contact Us
                </a>
                <a
                    href="{{ route('pages.privacy-policy') }}"
                    class="text-xl font-semibold hover:text-accent transition-colors"
                    wire:navigate
                >
                    Privacy Policy
                </a>
                <a
                    href="{{ route('pages.terms-and-conditions') }}"
                    class="text-xl font-semibold hover:text-accent transition-colors"
                    wire:navigate
                >
                    Terms and Conditions
                </a>
                <a
                    href="{{ route('pages.refund-policy') }}"
                    class="text-xl font-semibold hover:text-accent transition-colors"
                    wire:navigate
                >
                    Refund Policy
                </a>
            </nav>
            <div class="shrink-0 pt-5 gap-2 flex items-center justify-center">
                @if(auth()->check())
                    <flux:button href="{{ route('dashboard') }}" wire:navigate.hover variant="primary" class="w-full">
                        Dashboard
                    </flux:button>
                @else
                    <flux:button href="{{ route('login') }}" class="w-full" wire:navigate.hover>
                        Log in
                    </flux:button>
                    <flux:button href="{{ route('register') }}" wire:navigate.hover variant="primary" class="w-full">
                        Get Started
                    </flux:button>
                @endif
            </div>
        </div>
    </aside>
@endif

{{ $slot }}

@if($showFooter ?? true)
    <footer class="border-t border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
        <div
            class="container mx-auto px-4 md:px-6 flex flex-col gap-6 py-8 md:flex-row md:items-center md:justify-between md:py-12">
            <div class="flex items-center gap-2">
                <div class="h-8 w-8 rounded-md bg-accent flex items-center justify-center text-accent-foreground">SC
                </div>
                <span class="text-xl font-semibold">ShelfCurator</span>
            </div>
            <nav class="flex gap-4 sm:gap-6 flex-wrap">
                <a
                    href="{{ route('pages.pricing') }}"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                >
                    Pricing
                </a>
                <a
                    href="{{ route('pages.contact-us') }}"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                    wire:navigate.hover
                >
                    Contact Us
                </a>
                <a
                    href="{{ route('pages.privacy-policy') }}"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                    wire:navigate.hover
                >
                    Privacy Policy
                </a>
                <a
                    href="{{ route('pages.terms-and-conditions') }}"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                    wire:navigate.hover
                >
                    Terms and Conditions
                </a>
                <a
                    href="{{ route('pages.refund-policy') }}"
                    class="text-sm font-medium text-muted-foreground hover:text-accent transition-colors"
                    wire:navigate.hover
                >
                    Refund Policy
                </a>
            </nav>
            <div class="text-sm text-muted-foreground">© {{ date('Y') }} ShelfCurator. All rights reserved.</div>
        </div>
    </footer>
@endif

<x-notification />

@fluxScripts

@stack('scripts')
</body>
</html>
