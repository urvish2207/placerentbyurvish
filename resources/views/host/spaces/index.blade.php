@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

    <h2 class="text-3xl font-bold">My Spaces</h2>

    <a href="{{ route('host.spaces.create') }}" class="btn-primary">
        + Create Space
    </a>

</div>

@if($spaces->isEmpty())

<div class="card text-center py-16">
    <h3 class="text-xl font-semibold mb-2">No spaces yet</h3>
    <p class="text-gray-500">Create your first space</p>
</div>

@else

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

@foreach($spaces as $space)

<div class="card">

    <h3 class="text-xl font-semibold mb-2">{{ $space->title }}</h3>

    <p class="text-gray-600 mb-2">
        {{ $space->city }}, {{ $space->country }}
    </p>

    <p class="font-bold text-indigo-600 mb-4">
        ₹{{ $space->price }}
    </p>

   <a href="{{ route('host.spaces.edit', $space) }}"
   class="btn-secondary">
    Edit
</a>


</div>

@endforeach

</div>

@endif

@endsection
