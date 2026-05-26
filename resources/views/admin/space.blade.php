@extends('layouts.app')

@section('content')



<h2 class="text-3xl font-bold mb-6">Manage Spaces</h2>

@if(session('success'))
<div class="bg-green-100 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

<div class="grid md:grid-cols-3 gap-6">

@foreach($spaces as $space)

<div class="bg-white shadow rounded p-4">

    @if($space->images->first())
        <img src="{{ asset('storage/'.$space->images->first()->image_path) }}"
             class="w-full h-40 object-cover rounded mb-3">
    @endif

    <h3 class="font-bold">{{ $space->title }}</h3>

    <p class="text-sm text-gray-500">
        Owner: {{ $space->user->name ?? 'N/A' }}
    </p>

    <p class="text-indigo-600 font-bold">₹{{ $space->price }}</p>

    <form method="POST" action="{{ route('admin.spaces.delete', $space->id) }}">
        @csrf
        @method('DELETE')

        <button class="bg-red-500 text-white px-4 py-2 rounded mt-2">
            Delete
        </button>
    </form>

</div>

@endforeach

</div>





@endsection
