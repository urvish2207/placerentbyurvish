<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PlaceRent') }} — Book Extraordinary Spaces</title>
    <meta name="description" content="Discover and book unique spaces for events, meetings, parties, and more with PlaceRent.">

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <script>
        // Immediately apply saved theme before paint to prevent flash
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.className = theme;
        })();
    </script>
</head>

<body class="min-h-screen flex flex-col">

<!-- NOISE OVERLAY FOR PREMIUM TEXTURE -->
<div class="noise-overlay"></div>

<!-- PARTICLES BACKGROUND -->
<canvas id="particles-canvas"></canvas>

<!-- ══════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════ -->
<nav class="sticky top-0 z-50">
    <div class="container-custom flex justify-between items-center py-3">

        <!-- LOGO -->
        <a href="/" class="flex items-center gap-2.5 group" id="site-logo">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-300/40 group-hover:shadow-indigo-400/50 group-hover:scale-110 transition-all duration-300">
                <i data-lucide="map-pin" class="w-5 h-5"></i>
            </div>
            <span class="text-xl font-black tracking-tight gradient-text">PlaceRent</span>
        </a>

        <!-- DESKTOP NAV -->
        <div class="hidden md:flex items-center gap-1">
            <a href="/" class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600" style="color: var(--text-secondary)">Home</a>
            <a href="{{ route('spaces.index') }}" class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600" style="color: var(--text-secondary)">Explore</a>

            @auth
                <a href="{{ route('bookings.my') }}" class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600" style="color: var(--text-secondary)">Bookings</a>
                <a href="{{ route('dashboard') }}" class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600" style="color: var(--text-secondary)">Dashboard</a>
            @endauth
        </div>

        <!-- RIGHT ACTIONS -->
        <div class="flex items-center gap-2">

            <!-- THEME TOGGLE -->
            <button class="theme-toggle" id="theme-toggle" title="Toggle theme" aria-label="Toggle dark mode">
                <span class="sun-icon"><i data-lucide="sun" class="w-5 h-5"></i></span>
                <span class="moon-icon"><i data-lucide="moon" class="w-5 h-5"></i></span>
            </button>

            @auth
                <!-- HOST / ADMIN BADGE -->
                @if(auth()->user()->role === 'host')
                    <a href="{{ route('host.spaces.index') }}" class="hidden md:inline-flex btn-primary !py-2 !px-4 !text-xs">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        Host Panel
                    </a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center gap-1.5 bg-rose-600 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg shadow-rose-300/30 hover:bg-rose-700 transition-all">
                        <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                        Admin
                    </a>
                @endif

                <!-- USER AVATAR -->
                <div class="relative" id="user-menu-container">
                    <button id="user-menu-btn" class="flex items-center gap-2 px-3 py-2 rounded-2xl border hover:border-indigo-300 transition-all" style="border-color: var(--border); background: var(--bg-secondary)">
                        <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-semibold hidden sm:block" style="color: var(--text-primary)">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5" style="color: var(--text-muted)"></i>
                    </button>

                    <!-- DROPDOWN -->
                    <div id="user-menu-dropdown" class="hidden absolute right-0 mt-2 w-52 card !p-2 z-50" style="border-radius: 18px; box-shadow: 0 20px 60px -10px rgba(0,0,0,0.2)">
                        <div class="px-3 py-2 mb-1">
                            <p class="text-xs font-bold" style="color: var(--text-muted)">Signed in as</p>
                            <p class="text-sm font-semibold truncate" style="color: var(--text-primary)">{{ auth()->user()->email }}</p>
                        </div>
                        <hr style="border-color: var(--border)" class="mb-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20" style="color: var(--text-secondary)">
                            <i data-lucide="bar-chart-2" class="w-4 h-4"></i> Dashboard
                        </a>
                        <a href="{{ route('bookings.my') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20" style="color: var(--text-secondary)">
                            <i data-lucide="calendar" class="w-4 h-4"></i> My Bookings
                        </a>
                        <hr style="border-color: var(--border)" class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 rounded-xl text-sm transition-all hover:bg-red-50 dark:hover:bg-red-900/20 text-rose-500">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>

            @else
                <a href="{{ route('login') }}" class="hidden sm:block text-sm font-semibold px-4 py-2 rounded-xl transition-all hover:text-indigo-600" style="color: var(--text-secondary)">Login</a>
                <a href="{{ route('register') }}" class="btn-primary !py-2.5 !px-5 !text-sm">
                    Get Started
                </a>
            @endauth

            <!-- MOBILE MENU TOGGLE -->
            <button id="mobile-menu-btn" class="md:hidden theme-toggle">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
        </div>

    </div>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="hidden mobile-menu md:hidden">
        <div class="container-custom py-4 space-y-1">
            <a href="/" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium" style="color: var(--text-secondary)">
                <i data-lucide="home" class="w-4 h-4"></i> Home
            </a>
            <a href="{{ route('spaces.index') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium" style="color: var(--text-secondary)">
                <i data-lucide="compass" class="w-4 h-4"></i> Explore Spaces
            </a>
            @auth
                <a href="{{ route('bookings.my') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium" style="color: var(--text-secondary)">
                    <i data-lucide="calendar" class="w-4 h-4"></i> My Bookings
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium" style="color: var(--text-secondary)">
                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i> Dashboard
                </a>
                @if(auth()->user()->role === 'host')
                    <a href="{{ route('host.spaces.index') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-indigo-600">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Host Panel
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="px-1">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm text-rose-500 font-semibold w-full">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium text-indigo-600">
                    <i data-lucide="log-in" class="w-4 h-4"></i> Login
                </a>
                <a href="{{ route('register') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-indigo-600">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Create Account
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- ALERTS -->
<div class="container-custom mt-5 z-10 relative">
    @if(session('success'))
        <div class="alert-success mb-4 flex items-center gap-3">
            <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error mb-4 flex items-center gap-3">
            <i data-lucide="x-circle" class="w-5 h-5 flex-shrink-0"></i>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error mb-4">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                <span class="font-semibold text-sm">Please fix the following:</span>
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<!-- MAIN -->
<main class="flex-1 container-custom pt-6 pb-16">
    @yield('content')
</main>

<!-- FOOTER -->
<footer>
    <div class="container-custom py-12 grid md:grid-cols-4 gap-10">

        <div class="md:col-span-2">
            <a href="/" class="flex items-center gap-2 mb-4">
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center text-white">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                </div>
                <span class="text-lg font-black gradient-text">PlaceRent</span>
            </a>
            <p class="text-sm leading-relaxed mb-6" style="color: var(--text-muted)">
                Book extraordinary spaces for every occasion — from intimate meetings to grand celebrations.
            </p>
            <div class="flex items-center gap-3">
                <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:bg-indigo-100 dark:hover:bg-indigo-900/30" style="background: var(--bg-secondary); color: var(--text-muted)">
                    <i data-lucide="twitter" class="w-4 h-4"></i>
                </a>
                <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:bg-indigo-100 dark:hover:bg-indigo-900/30" style="background: var(--bg-secondary); color: var(--text-muted)">
                    <i data-lucide="instagram" class="w-4 h-4"></i>
                </a>
                <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:bg-indigo-100 dark:hover:bg-indigo-900/30" style="background: var(--bg-secondary); color: var(--text-muted)">
                    <i data-lucide="linkedin" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <div>
            <h4 class="text-sm font-bold mb-4 tracking-wider" style="color: var(--text-primary)">PLATFORM</h4>
            <ul class="space-y-2.5">
                <li><a href="/" class="text-sm transition-colors hover:text-indigo-500" style="color: var(--text-muted)">Home</a></li>
                <li><a href="{{ route('spaces.index') }}" class="text-sm transition-colors hover:text-indigo-500" style="color: var(--text-muted)">Explore Spaces</a></li>
                <li><a href="{{ route('dashboard') }}" class="text-sm transition-colors hover:text-indigo-500" style="color: var(--text-muted)">Dashboard</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-sm font-bold mb-4 tracking-wider" style="color: var(--text-primary)">CONTACT</h4>
            <ul class="space-y-2.5">
                <li class="flex items-center gap-2 text-sm" style="color: var(--text-muted)">
                    <i data-lucide="mail" class="w-4 h-4 text-indigo-400"></i>
                    support@placerent.com
                </li>
                <li class="flex items-center gap-2 text-sm" style="color: var(--text-muted)">
                    <i data-lucide="phone" class="w-4 h-4 text-indigo-400"></i>
                    +91 98765 43210
                </li>
                <li class="flex items-center gap-2 text-sm" style="color: var(--text-muted)">
                    <i data-lucide="map-pin" class="w-4 h-4 text-indigo-400"></i>
                    India
                </li>
            </ul>
        </div>

    </div>

    <div class="container-custom pb-6 flex flex-col sm:flex-row justify-between items-center gap-2" style="border-top: 1px solid var(--border)">
        <p class="text-xs" style="color: var(--text-muted)">© {{ date('Y') }} PlaceRent. All rights reserved.</p>
        <p class="text-xs" style="color: var(--text-muted)">Built with ❤️ for extraordinary experiences</p>
    </div>
</footer>

<!-- ══════════════════════════════════════════
     GLOBAL SCRIPTS
═══════════════════════════════════════════ -->
<script>
    // ── Init Icons ────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        initParticles();
        initScrollReveal();
        initThemeToggle();
        initMobileMenu();
        initUserMenu();
    });

    // ── Theme Toggle ──────────────────────────
    function initThemeToggle() {
        const btn = document.getElementById('theme-toggle');
        if (!btn) return;

        btn.addEventListener('click', () => {
            const isDark = document.documentElement.classList.contains('dark');
            document.documentElement.className = isDark ? 'light' : 'dark';
            localStorage.setItem('theme', isDark ? 'light' : 'dark');
            lucide.createIcons(); // re-render icons after toggle
        });
    }

    // ── Mobile Menu ───────────────────────────
    function initMobileMenu() {
        const btn  = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (!btn || !menu) return;

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    // ── User Dropdown ─────────────────────────
    function initUserMenu() {
        const btn      = document.getElementById('user-menu-btn');
        const dropdown = document.getElementById('user-menu-dropdown');
        if (!btn || !dropdown) return;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            dropdown.classList.add('hidden');
        });
    }

    // ── Scroll Reveal ─────────────────────────
    function initScrollReveal() {
        const targets = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-stagger');

        if (!targets.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        targets.forEach(el => observer.observe(el));
    }

    // ── Particles ─────────────────────────────
    function initParticles() {
        const canvas  = document.getElementById('particles-canvas');
        if (!canvas) return;
        const ctx     = canvas.getContext('2d');
        let particles = [];
        let W, H;

        function resize() {
            W = canvas.width  = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }

        resize();
        window.addEventListener('resize', resize);

        function createParticles() {
            particles = [];
            const count = Math.floor((W * H) / 18000);
            for (let i = 0; i < count; i++) {
                particles.push({
                    x:    Math.random() * W,
                    y:    Math.random() * H,
                    r:    Math.random() * 2 + 0.5,
                    dx:   (Math.random() - 0.5) * 0.35,
                    dy:   (Math.random() - 0.5) * 0.35,
                    alpha: Math.random() * 0.5 + 0.15,
                });
            }
        }
        createParticles();
        window.addEventListener('resize', createParticles);

        function getColor() {
            return document.documentElement.classList.contains('dark')
                ? '120, 119, 198'
                : '99, 102, 241';
        }

        function draw() {
            ctx.clearRect(0, 0, W, H);
            const color = getColor();

            particles.forEach(p => {
                p.x += p.dx; p.y += p.dy;
                if (p.x < 0 || p.x > W) p.dx *= -1;
                if (p.y < 0 || p.y > H) p.dy *= -1;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${color}, ${p.alpha})`;
                ctx.fill();
            });

            // Draw connections
            particles.forEach((a, i) => {
                particles.slice(i + 1).forEach(b => {
                    const dist = Math.hypot(a.x - b.x, a.y - b.y);
                    if (dist < 120) {
                        ctx.beginPath();
                        ctx.moveTo(a.x, a.y);
                        ctx.lineTo(b.x, b.y);
                        ctx.strokeStyle = `rgba(${color}, ${0.06 * (1 - dist / 120)})`;
                        ctx.lineWidth = 0.8;
                        ctx.stroke();
                    }
                });
            });

            requestAnimationFrame(draw);
        }

        draw();
    }
</script>

</body>
</html>