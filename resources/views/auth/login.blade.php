@extends('layouts.app')

@section('content')

<div class="auth-container py-10">
    <div class="auth-card reveal">

        <!-- TOP DECORATION -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-600 rounded-t-3xl"></div>

        <div class="relative z-10">
            <!-- LOGO MARK -->
            <div class="flex flex-col items-center mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-300/40 mb-4 animate-bounce-in">
                    <i data-lucide="lock" class="w-7 h-7"></i>
                </div>
                <h2 class="text-2xl font-black" style="color: var(--text-primary)">Welcome back</h2>
                <p class="text-sm mt-1" style="color: var(--text-muted)">Sign in to continue to PlaceRent</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

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
                        <i data-lucide="key-round" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--text-muted)"></i>
                        <input type="password" name="password" placeholder="••••••••" required
                               class="input-field !pl-11" id="password-input">
                        <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2" style="color: var(--text-muted)">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-indigo-600">
                        <span class="text-sm" style="color: var(--text-secondary)">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-indigo-500 hover:text-indigo-600 transition-colors">
                        Forgot password?
                    </a>
                </div>

                <button class="btn-primary w-full !py-4 mt-2" type="submit">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <div class="relative flex items-center gap-4 mb-6">
                    <hr class="flex-1" style="border-color: var(--border)">
                    <span class="text-xs font-semibold" style="color: var(--text-muted)">OR</span>
                    <hr class="flex-1" style="border-color: var(--border)">
                </div>

                <p class="text-sm" style="color: var(--text-secondary)">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-bold text-indigo-500 hover:text-indigo-600 transition-colors ml-1">
                        Create one free →
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    const toggle = document.getElementById('toggle-password');
    const input  = document.getElementById('password-input');
    let visible  = false;

    if (toggle && input) {
        toggle.addEventListener('click', () => {
            visible = !visible;
            input.type = visible ? 'text' : 'password';
            toggle.innerHTML = visible
                ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>'
                : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
        });
    }
});
</script>

@endsection
