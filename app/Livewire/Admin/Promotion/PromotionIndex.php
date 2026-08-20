<?php

namespace App\Livewire\Admin\Promotion;

use App\Notifications\Promotion\InviteUser;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;

class PromotionIndex extends Component
{
    public $showPromotionModal = false;
    public $name = '';
    public $email = '';

    public function create(): void
    {
        $this->name = '';
        $this->email = '';
        $this->showPromotionModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        Notification::route('mail', $this->email)
            ->notify(new InviteUser($this->name));

        $this->showPromotionModal = false;
        $this->name = '';
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.admin.promotion.promotion-index');
    }
}
