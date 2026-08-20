<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.front')]
class RefundPolicy extends Component
{
    public function render()
    {
        return view('livewire.pages.refund-policy');
    }
}
