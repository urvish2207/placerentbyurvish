@extends('layouts.guest')

@section('content')

<div class="w-full max-w-md mx-auto">

    <h2 class="text-2xl font-bold mb-6 text-center">
        Forgot Password
    </h2>

    @if (session('status'))
        <div class="alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label class="block mb-2">Email</label>

        <input type="email"
               name="email"
               required
               class="input-field mb-4">

        <button class="btn-primary w-full">
            Send Reset Link
        </button>
    </form>

</div>

@endsection