<?php

namespace App\Livewire\Components;

use App\Helpers\DomainHelper;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewProfileButton extends Component
{
    public $url;

    public $btnLabel = 'View Profile';

    public $btnSize = 'base';

    public function mount(): void
    {
        $this->url = DomainHelper::getDomainUrl(auth()->user()->domain, auth()->user()->username);
    }

    #[On('domain-updated')]
    public function refreshUrl(): void
    {
        $this->url = DomainHelper::getDomainUrl(auth()->user()->domain, auth()->user()->username);
    }

    public function render(): View
    {
        return view('livewire.components.view-profile-button');
    }
}
