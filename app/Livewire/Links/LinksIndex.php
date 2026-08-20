<?php

namespace App\Livewire\Links;

use App\Forms\LinkForm;
use App\Models\Link;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class LinksIndex extends Component
{
    use WithPagination;

    public LinkForm $form;

    public $showLinkModal = false;

    public function create(): void
    {
        $this->form->reset();
        $this->showLinkModal = true;
    }

    public function editLink(int $linkId): void
    {
        $link = Link::query()
            ->where('user_id', auth()->id())
            ->findOrFail($linkId);

        $this->form->set($link);
        $this->showLinkModal = true;
    }

    public function save(): void
    {
        try {
            $this->form->save();
        } catch (\Exception $exception) {
            if (! $exception instanceof ValidationException) {
                $this->dispatch('notify', message: $exception->getMessage(), type: 'error');

                return;
            }

            throw $exception;
        }

        $this->form->reset();
        $this->showLinkModal = false;
    }

    public function delete(int $linkId): void
    {
        $link = Link::query()->find($linkId);

        if ($link && $link->user_id === auth()->id()) {
            $link->delete();
        }
    }

    public function toggleActive(int $linkId): void
    {
        $link = Link::query()
            ->where('user_id', auth()->id())
            ->findOrFail($linkId);

        $link->update(['is_active' => ! $link->is_active]);
    }

    public function render(): View
    {
        $links = auth()->user()->links()->latest()->paginate(10);

        return view('livewire.links.links-index', [
            'links' => $links,
        ]);
    }
}
