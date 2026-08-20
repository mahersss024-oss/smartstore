<?php

namespace App\Livewire;

use App\Models\Link;
use App\Models\Product;
use Illuminate\View\View;
use Laravel\Paddle\Exceptions\PaddleException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    /**
     * @throws PaddleException
     */
    public function goToCustomerPortalUrl(): void
    {
        $customer_portal_url = auth()->user()->getCustomerPortalUrl();

        $this->dispatch('open-new-tab', $customer_portal_url);
    }

    public function render(): View
    {
        $totalProducts = Product::query()
            ->where('user_id', auth()->id())
            ->count();

        $totalLinks = Link::query()
            ->where('user_id', auth()->id())
            ->count();

        return view('dashboard', compact('totalProducts', 'totalLinks'));
    }
}
