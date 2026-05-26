@extends('layouts.app')

@section('content')

<div class="space-y-10 pb-10">

    <!-- PAGE HEADER -->
    <div class="page-header px-8 py-10 reveal">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-bold tracking-widest mb-2 text-indigo-500 uppercase">My Account</p>
                <h1 class="text-3xl font-black" style="color: var(--text-primary)">My Bookings</h1>
                <p class="mt-1 text-sm" style="color: var(--text-muted)">All your past and upcoming reservations in one place.</p>
            </div>
            <a href="{{ route('spaces.index') }}" class="btn-primary self-start">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Book a Space
            </a>
        </div>
    </div>

    @if($bookings->isEmpty())
        <div class="card text-center py-24 reveal">
            <div class="w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center" style="background: var(--bg-secondary)">
                <i data-lucide="calendar-x" class="w-12 h-12" style="color: var(--text-muted)"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2" style="color: var(--text-primary)">No bookings yet</h3>
            <p class="text-sm mb-8 max-w-sm mx-auto" style="color: var(--text-muted)">
                You haven't made any bookings yet. Explore our spaces and find the perfect one for you!
            </p>
            <a href="{{ route('spaces.index') }}" class="btn-primary inline-flex">
                <i data-lucide="compass" class="w-4 h-4"></i>
                Explore Spaces
            </a>
        </div>

    @else
        <div class="grid gap-6 reveal-stagger">

            @foreach($bookings as $booking)
                <div class="card !p-0 group">
                    <div class="flex flex-col sm:flex-row">

                        <!-- IMAGE -->
                        <div class="relative sm:w-48 flex-shrink-0">
                            @if($booking->space->images->count())
                                <img src="{{ asset('storage/'.$booking->space->images->first()->image_path) }}"
                                     class="w-full h-40 sm:h-full object-cover sm:rounded-l-3xl rounded-t-3xl sm:rounded-tr-none">
                            @else
                                <div class="w-full h-40 sm:h-full sm:rounded-l-3xl rounded-t-3xl sm:rounded-tr-none flex items-center justify-center" style="background: var(--bg-secondary)">
                                    <i data-lucide="image" class="w-8 h-8" style="color: var(--text-muted)"></i>
                                </div>
                            @endif
                            <!-- STATUS OVERLAY -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold backdrop-blur
                                    @if($booking->status === 'cancelled') status-cancelled
                                    @elseif($booking->payment_status === 'paid') status-paid
                                    @else status-pending
                                    @endif">
                                    @if($booking->status === 'cancelled') Cancelled
                                    @elseif($booking->payment_status === 'paid') Confirmed
                                    @else Pending
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- DETAILS -->
                        <div class="flex-1 p-6">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <div>
                                    <h3 class="text-xl font-bold mb-1 group-hover:text-indigo-500 transition-colors" style="color: var(--text-primary)">
                                        {{ $booking->space->title }}
                                    </h3>
                                    <p class="text-sm flex items-center gap-1.5 mb-4" style="color: var(--text-muted)">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-indigo-400"></i>
                                        {{ $booking->space->city ?? 'Location unavailable' }}
                                    </p>

                                    <div class="flex flex-wrap gap-4">
                                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-semibold" style="background: var(--bg-secondary); color: var(--text-secondary)">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-indigo-400"></i>
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}
                                        </div>
                                        <div class="flex items-center gap-1" style="color: var(--text-muted)">
                                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-semibold" style="background: var(--bg-secondary); color: var(--text-secondary)">
                                            <i data-lucide="calendar-check" class="w-3.5 h-3.5 text-indigo-400"></i>
                                            {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-2xl font-black text-indigo-500">₹{{ number_format($booking->total_price) }}</p>
                                    <p class="text-xs mt-0.5" style="color: var(--text-muted)">Total paid</p>
                                </div>
                            </div>

                            <!-- ACTIONS -->
                            <div class="mt-5 pt-5 flex flex-wrap items-center gap-3" style="border-top: 1px solid var(--border)">
                                <a href="{{ route('spaces.show', $booking->space) }}"
                                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-500 hover:text-indigo-600 transition-colors">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                    View Space
                                </a>

                                @if($booking->status !== 'cancelled' && \Carbon\Carbon::parse($booking->start_date)->isFuture())
                                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="ml-auto">
                                        @csrf
                                        <button onclick="return confirm('Are you sure you want to cancel this booking?')"
                                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-rose-500 hover:text-rose-600 transition-colors px-3 py-1.5 rounded-xl hover:bg-rose-50 dark:hover:bg-rose-900/20">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                            Cancel Booking
                                        </button>
                                    </form>
                                @elseif($booking->status === 'cancelled')
                                    <span class="ml-auto text-xs text-rose-400 italic">This booking was cancelled</span>
                                @else
                                    <span class="ml-auto flex items-center gap-1 text-xs text-emerald-500 font-semibold">
                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                                        Completed
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
</script>

@endsection
