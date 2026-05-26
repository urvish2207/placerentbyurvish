<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Space;
use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::count();
        $spaces = Space::count();
        $bookings = Booking::count();

        $revenue = Booking::where('payment_status', 'paid')->sum('total_price');

        return view('admin.dashboard', compact('users', 'spaces', 'bookings', 'revenue'));
    }

    public function spaces()
    {
        $spaces = Space::with('user', 'images')->latest()->get();
        return view('admin.space', compact('spaces'));
    }

    public function bookings()
    {
        $bookings = Booking::with('user', 'space')->latest()->get();
        return view('admin.booking', compact('bookings'));
    }

    public function deleteSpace($id)
    {
        Space::findOrFail($id)->delete();
        return back()->with('success', 'Space deleted');
    }

    public function deleteBooking($id)
    {
        Booking::findOrFail($id)->delete();
        return back()->with('success', 'Booking deleted');
    }
}