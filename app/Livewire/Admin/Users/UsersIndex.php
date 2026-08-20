<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class UsersIndex extends Component
{
    public function render(): View
    {
        $users = User::query()
            ->with('domain')
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.admin.users.users-index', compact('users'));
    }
}
