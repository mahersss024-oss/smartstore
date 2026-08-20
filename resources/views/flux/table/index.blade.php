@props([
    'paginate' => null,
])

@php
$classes = Flux::classes()
    ->add('w-full border-collapse')
    ->add('text-sm text-left')
    ->add('overflow-hidden');
@endphp

<div class="w-full overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
    <table {{ $attributes->class($classes) }} data-flux-table>
        {{ $slot }}
    </table>

    @if($paginate)
    <div class="px-4 py-3 bg-zinc-50 dark:bg-zinc-700 border-t border-zinc-200 dark:border-zinc-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-zinc-700 dark:text-zinc-300">
                Showing {{ $paginate->firstItem() ?? 0 }} to {{ $paginate->lastItem() ?? 0 }} of {{ $paginate->total() }} results
            </div>
            <div class="flex items-center space-x-2">
                @if($paginate->currentPage() > 1)
                    <a href="{{ $paginate->previousPageUrl() }}" class="px-3 py-1 text-sm border rounded-md border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                        Previous
                    </a>
                @endif

                <div class="flex items-center space-x-1">
                    @for ($i = 1; $i <= $paginate->lastPage(); $i++)
                        <a href="{{ $paginate->url($i) }}"
                           class="px-3 py-1 text-sm rounded-md {{ $paginate->currentPage() === $i ? 'bg-zinc-800 text-white dark:bg-white dark:text-zinc-800' : 'border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                            {{ $i }}
                        </a>
                    @endfor
                </div>

                @if($paginate->hasMorePages())
                    <a href="{{ $paginate->nextPageUrl() }}" class="px-3 py-1 text-sm border rounded-md border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                        Next
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
