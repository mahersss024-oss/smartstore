<flux:button
    variant="primary"
    as="a"
    href="{{ $url }}"
    target="_blank"
    class="!justify-between"
    :size="$btnSize"
>
    {{ $btnLabel }}
    <flux:icon name="arrow-up-right" class="size-4"/>
</flux:button>
