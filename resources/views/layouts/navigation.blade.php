<nav class="navbar">
    <div class="container-custom flex justify-between items-center py-4">
        <h1 class="text-xl font-bold text-indigo-600">PlaceRent</h1>

        <div class="flex items-center gap-6">
            <a href="/" class="nav-link">Home</a>
            <a href="/spaces" class="nav-link">Spaces</a>
            <a href="/bookings/my" class="nav-link">My Bookings</a>
            <a href="/dashboard" class="nav-link">Dashboard</a>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-secondary">Logout</button>
                </form>
            @else
                <a href="/login" class="btn-primary">Login</a>
            @endauth
        </div>
    </div>
</nav>
