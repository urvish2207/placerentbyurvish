@extends('layouts.app')

@section('content')

<div class="auth-container py-10">
    <div class="auth-card reveal">

        <!-- TOP DECORATION -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-violet-500 via-indigo-500 to-blue-500 rounded-t-3xl"></div>

        <div class="relative z-10">
            <div class="flex flex-col items-center mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-violet-300/40 mb-4 animate-bounce-in">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <h2 class="text-2xl font-black" style="color: var(--text-primary)">Create your account</h2>
                <p class="text-sm mt-1" style="color: var(--text-muted)">Join thousands of users on PlaceRent</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label class="text-xs font-bold tracking-wider uppercase" style="color: var(--text-muted)">Full Name</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--text-muted)"></i>
                        <input type="text" name="name" placeholder="John Doe" required
                               class="input-field !pl-11" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold tracking-wider uppercase" style="color: var(--text-muted)">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--text-muted)"></i>
                        <input type="email" name="email" placeholder="you@example.com" required
                               class="input-field !pl-11" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold tracking-wider uppercase" style="color: var(--text-muted)">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--text-muted)"></i>
                        <input type="password" name="password" placeholder="Min. 8 characters" required
                               class="input-field !pl-11">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold tracking-wider uppercase" style="color: var(--text-muted)">Confirm Password</label>
                    <div class="relative">
                        <i data-lucide="shield-check" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--text-muted)"></i>
                        <input type="password" name="password_confirmation" placeholder="Repeat password" required
                               class="input-field !pl-11">
                    </div>
                </div>

                <p class="text-xs" style="color: var(--text-muted)">
                    By registering, you agree to our
                    <a href="#" class="text-indigo-500 hover:underline">Terms of Service</a> and
                    <a href="#" class="text-indigo-500 hover:underline">Privacy Policy</a>.
                </p>

                <button class="btn-primary w-full !py-4" type="submit">
                    <i data-lucide="rocket" class="w-4 h-4"></i>
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <div class="relative flex items-center gap-4 mb-6">
                    <hr class="flex-1" style="border-color: var(--border)">
                    <span class="text-xs font-semibold" style="color: var(--text-muted)">OR</span>
                    <hr class="flex-1" style="border-color: var(--border)">
                </div>
                <p class="text-sm" style="color: var(--text-secondary)">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold text-indigo-500 hover:text-indigo-600 transition-colors ml-1">
                        Sign in →
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
</script>

@endsection
