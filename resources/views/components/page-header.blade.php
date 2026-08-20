@props([
    'title',
    'description',
])

<div class="relative mb-6 w-full">
    <div class="mb-6 sm:flex items-center justify-between">
        <div class="mb-4 sm:mb-0">
            <flux:heading size="xl" level="1">{{ $title }}</flux:heading>
            <flux:subheading size="lg">{{ $description }}</flux:subheading>
        </div>

        {{ $slot }}
    </div>

    <flux:separator variant="subtle" />
</div>
