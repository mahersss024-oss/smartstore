<?php

namespace App\Livewire;

use App\Models\Link;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.front', ['showHeader' => false, 'showFooter' => false])]
class UserProfile extends Component
{
    use WithPagination;

    public User $user;
    public string $productSearch = '';
    public string $linkSearch = '';

    public function mount(string $username): void
    {
        $this->user = User::query()
            ->where('username', $username)
            ->firstOrFail();
    }

    public function updatedProductSearch(): void
    {
        $this->resetPage('products_page');
    }

    public function updatedLinkSearch(): void
    {
        $this->resetPage('links_page');
    }

    public function render(): View
    {
        $products = Product::query()
            ->where('user_id', $this->user->id)
            ->when($this->productSearch, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->productSearch . '%')
                      ->orWhere('description', 'like', '%' . $this->productSearch . '%');
                });
            })
            ->active()
            ->latest('created_at')
            ->paginate(12, ['*'], 'products_page');

        $links = Link::query()
            ->where('user_id', $this->user->id)
            ->when($this->linkSearch, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->linkSearch . '%')
                      ->orWhere('description', 'like', '%' . $this->linkSearch . '%')
                      ->orWhere('url', 'like', '%' . $this->linkSearch . '%');
                });
            })
            ->active()
            ->latest('created_at')
            ->paginate(10, ['*'], 'links_page');

        $socialIcons = $this->user->socialIcons()
            ->active()
            ->get();

        return view('livewire.user-profile', [
            'products' => $products,
            'links' => $links,
            'socialIcons' => $socialIcons,
        ])->title($this->user->display_name ?? config('app.name'));
    }
}
