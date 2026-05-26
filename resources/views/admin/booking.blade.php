@extends('layouts.app')

@section('content')



<h2 class="text-3xl font-bold mb-6">Manage Bookings</h2>

@if(session('success'))
<div class="bg-green-100 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

@foreach($bookings as $booking)

<div class="card mb-4 flex justify-between items-center">

    <div>
        <h3>{{ $booking->space->title ?? 'Deleted' }}</h3>

        <p>User: {{ $booking->user->name ?? 'N/A' }}</p>

        <p>{{ $booking->start_date }} → {{ $booking->end_date }}</p>

        <p class="text-indigo-600 font-bold">₹{{ $booking->total_price }}</p>
    </div>

    <form method="POST" action="{{ route('admin.bookings.delete', $booking->id) }}">
        @csrf
        @method('DELETE')

        <button class="bg-red-500 text-white px-4 py-2 rounded">
            Delete
        </button>
    </form>

</div>

@endforeach


@endsection
