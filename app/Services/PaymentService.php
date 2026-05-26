<?php

namespace App\Services;

use Stripe\StripeClient;

class PaymentService
{
    public function create($amount)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        return $stripe->paymentIntents->create([
            'amount' => (int) round($amount * 100),
            'currency' => 'inr',
        ]);
    }
}
