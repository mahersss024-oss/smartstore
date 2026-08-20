@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => null,
])

@php
// Define alert types with their colors and default icons
$alertTypes = [
    'info' => [
        'icon' => 'information-circle',
        'bg' => 'bg-blue-50 dark:bg-blue-950/50',
        'border' => 'border-blue-200 dark:border-blue-800',
        'text' => 'text-blue-700 dark:text-blue-300',
        'icon_color' => 'text-blue-400 dark:text-blue-300',
    ],
    'success' => [
        'icon' => 'check-circle',
        'bg' => 'bg-green-50 dark:bg-green-950/50',
        'border' => 'border-green-200 dark:border-green-800',
        'text' => 'text-green-700 dark:text-green-300',
        'icon_color' => 'text-green-400 dark:text-green-300',
    ],
    'warning' => [
        'icon' => 'exclamation-triangle',
        'bg' => 'bg-yellow-50 dark:bg-yellow-950/50',
        'border' => 'border-yellow-200 dark:border-yellow-800',
        'text' => 'text-yellow-700 dark:text-yellow-300',
        'icon_color' => 'text-yellow-400 dark:text-yellow-300',
    ],
    'error' => [
        'icon' => 'x-circle',
        'bg' => 'bg-red-50 dark:bg-red-950/50',
        'border' => 'border-red-200 dark:border-red-800',
        'text' => 'text-red-700 dark:text-red-300',
        'icon_color' => 'text-red-400 dark:text-red-300',
    ],
];

// Set default icon if not specified
if ($icon === null) {
    $icon = $alertTypes[$type]['icon'] ?? 'information-circle';
}

$classes = Flux::classes()
    ->add('p-4 rounded-md border')
    ->add($alertTypes[$type]['bg'] ?? 'bg-blue-50 dark:bg-blue-950/50')
    ->add($alertTypes[$type]['border'] ?? 'border-blue-200 dark:border-blue-800')
    ->add($alertTypes[$type]['text'] ?? 'text-blue-700 dark:text-blue-300');
@endphp

<div {{ $attributes->class($classes) }} role="alert" data-flux-alert>
    <div class="flex">
        <div class="flex-shrink-0">
            <flux:icon :icon="$icon" variant="mini" class="{{ $alertTypes[$type]['icon_color'] ?? 'text-blue-400' }}" />
        </div>
        <div class="ml-3">
            <div class="text-sm font-medium">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
        <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
                <button type="button" class="inline-flex rounded-md p-1.5 {{ $alertTypes[$type]['text'] ?? 'text-blue-700' }} hover:bg-blue-100 dark:hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600" aria-label="Dismiss">
                    <span class="sr-only">Dismiss</span>
                    <flux:icon icon="x-mark" variant="micro" />
                </button>
            </div>
        </div>
        @endif
    </div>
</div> 