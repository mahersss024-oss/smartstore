<?php

namespace App\Livewire\Pages;

use Laravel\Paddle\Exceptions\PaddleException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.front')]
class Pricing extends Component
{
    public function login(): void
    {
        session(['url.intended' => route('pages.pricing')]);

        $this->redirectRoute('login', navigate: true);
    }

    /**
     * @throws PaddleException
     */
    public function render()
    {
        $pro_monthly_checkout = null;
        $pro_yearly_checkout = null;
        $customer_portal_url = null;

        // Ensure the user is authenticated before proceeding
        if (auth()->check()) {
            $pro_monthly_checkout = auth()->user()->subscribe(config('cashier.price.pro.monthly'))
                ->returnTo(route('dashboard'));

            $pro_yearly_checkout = auth()->user()->subscribe(config('cashier.price.pro.yearly'))
                ->returnTo(route('dashboard'));

            $customer_portal_url = auth()->user()->getCustomerPortalUrl();
        }

        return view('livewire.pages.pricing', compact('pro_monthly_checkout', 'pro_yearly_checkout', 'customer_portal_url'));
    }
}
