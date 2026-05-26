@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-20">

    <div class="card text-center py-12">

        <!-- ICON -->
        <div class="text-green-500 text-6xl mb-4">
            🎉
        </div>

        <h1 class="text-3xl font-bold mb-3">
            Booking Confirmed!
        </h1>

        <p class="text-gray-500 mb-8">
            Your payment was successful.
        </p>

        <!-- BOOKING DETAILS -->
        <div class="bg-gray-50 rounded-xl p-6 text-left mb-6">

            <h3 class="font-semibold mb-3">Booking Details</h3>

            <p><strong>Space:</strong> {{ $booking->space->title }}</p>
            <p><strong>City:</strong> {{ $booking->space->city }}</p>
            <p><strong>Dates:</strong> {{ $booking->start_date }} → {{ $booking->end_date }}</p>
            <p><strong>Total Paid:</strong> ₹{{ $booking->total_price }}</p>

        </div>

        <div class="flex justify-center gap-4">

            <a href="{{ route('spaces.index') }}" class="btn-secondary">
                Explore More
            </a>

            <a href="{{ route('bookings.my') }}" class="btn-primary">
                My Bookings
            </a>

        </div>

        <p class="text-sm text-gray-400 mt-6">
            Redirecting in 5 seconds...
        </p>

    </div>

</div>

<!-- CONFETTI -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
confetti({
    particleCount: 120,
    spread: 70,
    origin: { y: 0.6 }
});

// AUTO REDIRECT
setTimeout(() => {
    window.location.href = "{{ route('bookings.my') }}";
}, 5000);
</script>

@endsection
