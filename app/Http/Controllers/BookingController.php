<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\BookingConfirmed;

class BookingController extends Controller
{
    /**
     * Show booking form for a space
     */public function create(Space $space)
{
    // Ensure slots exist
    if (!$space->available_slots) {
        $space->available_slots = ['full_day'];
    }

    // Get all bookings for this space
    $bookings = Booking::where('space_id', $space->id)
        ->get(['start_date', 'end_date']);

    // Convert booked ranges into disabled dates array
    $disabledDates = [];

    foreach ($bookings as $booking) {
        $start = \Carbon\Carbon::parse($booking->start_date);
        $end = \Carbon\Carbon::parse($booking->end_date);

        while ($start <= $end) {
            $disabledDates[] = $start->format('Y-m-d');
            $start->addDay();
        }
    }

    return view('bookings.create', compact('space', 'disabledDates'));
}

    /**
     * Store booking in database
     */
    public function store(Request $request, Space $space)
{
    $request->validate([
        'start_date' => 'required|date|after_or_equal:today',
        'end_date'   => 'date|after:start_date',
        'people_count' => 'required|integer|min:1',
        'time_slot' => 'required'
    ]);

    // Capacity validation
    if ($request->people_count > $space->capacity) {
        return back()->withErrors('Exceeds maximum capacity.');
    }

    if ($request->people_count < $space->min_capacity) {
        return back()->withErrors('Below minimum capacity.');
    }

    // Prevent overbooking
    $totalBooked = Booking::where('space_id', $space->id)
        ->sum('people_count');

    if (($totalBooked + $request->people_count) > $space->capacity) {
        return back()->withErrors('Not enough capacity available.');
    }

    // Date conflict check
    $conflict = Booking::where('space_id', $space->id)
        ->where(function ($query) use ($request) {
            $query->where('start_date', '<', $request->end_date)
                  ->where('end_date', '>', $request->start_date);
        })
        ->exists();

    if ($conflict) {
        return back()->withErrors('This space is already booked for selected dates.');
    }

    $days = \Carbon\Carbon::parse($request->start_date)
        ->diffInDays(\Carbon\Carbon::parse($request->end_date));

    $totalPrice = $days * $space->price;

    $booking = Booking::create([
        'space_id' => $space->id,
        'user_id' => auth()->id(),
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'total_price' => $totalPrice,
        'people_count' => $request->people_count,
        'time_slot' => $request->time_slot,
        'status' => 'confirmed'
    ]);

    return redirect()->route('payment.checkout', $booking);
}

    /**
     * Booking success page
     */
    public function success()
    {
        return view('bookings.success');
    }

    /**
     * Show logged-in user's bookings
     */
    public function myBookings()
{
    $bookings = \App\Models\Booking::with('space')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('bookings.mine', compact('bookings'));
}
public function cancel(Booking $booking)
{
    // Only owner can cancel
    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    // Prevent cancelling past bookings
    if (\Carbon\Carbon::parse($booking->start_date)->isPast()) {
        return back()->with('error', 'Cannot cancel past bookings');
    }

    $booking->update([
        'status' => 'cancelled'
    ]);

    return back()->with('success', 'Booking cancelled successfully');
}
}
