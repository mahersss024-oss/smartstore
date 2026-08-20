<?php

namespace App\Forms;

use App\Models\Link;
use Exception;
use Livewire\Form;

class LinkForm extends Form
{
    public ?Link $link = null;

    public ?string $title = '';

    public ?string $description = null;

    public ?string $url = '';

    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'is_active' => ['boolean'],
        ];
    }

    public function set(Link $link): void
    {
        $this->link = $link;
        $this->title = $link->title;
        $this->description = $link->description;
        $this->url = $link->url;
        $this->is_active = $link->is_active;
    }

    /**
     * @throws Exception
     */
    public function save(): void
    {
        $validated = $this->validate();

        if ($this->link) {
            $this->link->update($validated);
        } else {
            if (! auth()->user()->subscribed() && auth()->user()->products()->count() > 30) {
                throw new Exception('You can only add maximum of 10 links. Subscribe to a premium plan to add more.');
            }

            auth()->user()->links()->create($validated);
        }
    }
}
