<?php

namespace App\Livewire;

use App\Models\Domain;
use App\Models\Link;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public ?User $user = null;

    public ?Domain $domain;

    public string $productSearch = '';
    public string $linkSearch = '';

    public function mount(): void
    {
        // Remove 'www.' prefix from the host for comparison
        $host = preg_replace('/^www\./i', '', request()->getHost());

        // Check if this is not the main domain and is a user's domain
        if ($host !== config('app.domain')) {
            // Find the domain in the database
            $this->domain = Domain::query()
                ->where('name', $host)
                ->firstOrFail();

            $this->user = $this->domain->user;
        }
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
        if ($this->user) {
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
            ])->layout('components.layouts.front', ['showHeader' => false, 'showFooter' => false])
                ->title($this->user->display_name ?? config('app.name'));
        }

        // Default: show welcome page
        return view('welcome')->layout('components.layouts.front');
    }
}
