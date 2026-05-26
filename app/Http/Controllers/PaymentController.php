<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Booking;

class PaymentController extends Controller
{
    

    public function checkout(Booking $booking)
    {
        

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => 'Space Booking',
                    ],
                    'unit_amount' => $booking->total_price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', $booking),
            'cancel_url'  => route('payment.cancel', $booking),
        ]);

        $booking->update([
            'stripe_session_id' => $session->id
        ]);

        return redirect($session->url);
    }

   public function success(Booking $booking)
{
    $booking->update([
        'payment_status' => 'paid'
    ]);

    return view('bookings.success', compact('booking'));
}

    public function cancel()
    {
        return redirect()->route('spaces.index')
            ->with('error', 'Payment cancelled');
    }
}
