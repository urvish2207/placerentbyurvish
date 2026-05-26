@extends('layouts.app')

@section('content')


<h2 class="text-3xl font-bold mb-6">Admin Dashboard</h2>

<div class="grid md:grid-cols-4 gap-6">

    <div class="card text-center">
        <p>Users</p>
        <h3 class="text-3xl font-bold">{{ $users }}</h3>
    </div>

    <div class="card text-center">
        <p>Spaces</p>
        <h3 class="text-3xl font-bold">{{ $spaces }}</h3>
    </div>

    <div class="card text-center">
        <p>Bookings</p>
        <h3 class="text-3xl font-bold">{{ $bookings }}</h3>
    </div>

    <div class="card text-center">
        <p>Revenue</p>
        <h3 class="text-3xl font-bold">₹{{ $revenue }}</h3>
    </div>

</div>

<div class="mt-8 flex gap-4">
    <a href="{{ route('admin.spaces') }}" class="btn-primary">Manage Spaces</a>
    <a href="{{ route('admin.bookings') }}" class="btn-secondary">Manage Bookings</a>
</div>


@endsection
