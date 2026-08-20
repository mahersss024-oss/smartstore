<?php

namespace App\Traits;

use Laravel\Paddle\Cashier;
use Laravel\Paddle\Exceptions\PaddleException;

trait HasSubscription
{
    public function subscribedToPlan($planName)
    {
        $plan = config("plans.$planName");

        if (is_array($plan)) {
            $plan = array_values($plan); // multiple IDs
        }

        return $this->subscribed($plan, 'default');
    }

    /**
     * @throws PaddleException
     */
    public function getCustomerPortalUrl(): ?string
    {
        $customer_id = $this->customer?->paddle_id;

        if (! $customer_id) {
            return null;
        }

        return Cashier::api('POST', "customers/{$customer_id}/portal-sessions")['data']['urls']['general']['overview'];
    }
}
