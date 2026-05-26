@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Profile
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-8">
        <form method="POST" action="{{ route('profile.update') }}"
              class="bg-white p-6 rounded shadow">
            @csrf
            @method('PATCH')

            <label class="block mb-2">Name</label>
            <input type="text" name="name"
                   value="{{ auth()->user()->name }}"
                   class="w-full border p-2 rounded mb-4">

            <label class="block mb-2">Email</label>
            <input type="email" name="email"
                   value="{{ auth()->user()->email }}"
                   class="w-full border p-2 rounded mb-4">

            <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>
    </div>
@endsection