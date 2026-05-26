@extends('layouts.guest')

@section('content')

<div class="w-full max-w-md mx-auto">

    <h2 class="text-2xl font-bold mb-6 text-center">
        Reset Password
    </h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <!-- EMAIL -->
        <label class="block mb-2">Email</label>
        <input type="email"
               name="email"
               value="{{ request('email') }}"
               required
               class="input-field mb-4">

        <!-- PASSWORD -->
        <label class="block mb-2">New Password</label>
        <input type="password"
               name="password"
               required
               class="input-field mb-4">

        <!-- CONFIRM -->
        <label class="block mb-2">Confirm Password</label>
        <input type="password"
               name="password_confirmation"
               required
               class="input-field mb-6">

        <button class="btn-primary w-full">
            Reset Password
        </button>

    </form>

</div>

@endsection