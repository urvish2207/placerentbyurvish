<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Stats
    $spaces = \App\Models\Space::where('user_id', $user->id)->count();

    $bookings = \App\Models\Booking::whereHas('space', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->count();

    $revenue = \App\Models\Booking::whereHas('space', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->where('payment_status', 'paid')->sum('total_price');

    $recentBookings = \App\Models\Booking::with('space','user')->latest()->take(5)->get();

    // Chart data (last 7 bookings)
    $chartBookings = \App\Models\Booking::latest()->take(7)->get()->reverse();

    $labels = $chartBookings->pluck('created_at')->map(fn($d) => $d->format('d M'));
    $amounts = $chartBookings->pluck('total_price');

    return view('dashboard', compact(
        'spaces',
        'bookings',
        'revenue',
        'recentBookings',
        'labels',
        'amounts'
    ));
}

}
