@extends('layouts.app')

@section('content')

<div class="space-y-32 pb-20">

<!-- SCROLL TO TOP -->
<button id="scroll-top" class="fixed bottom-8 right-8 z-40 w-12 h-12 rounded-2xl btn-primary !p-0 shadow-xl opacity-0 translate-y-4 transition-all duration-300" aria-label="Scroll to top">
    <i data-lucide="arrow-up" class="w-5 h-5"></i>
</button>

    <!-- 🔥 HERO SECTION -->
    <section class="relative pt-16 pb-20 overflow-hidden reveal">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-sm font-semibold mb-6 border border-indigo-100">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Trusted by 10,000+ happy hosts
                </div>
                <h1 class="hero-title mb-6">
                    Discover & Book <br> 
                    <span class="text-indigo-600">Exceptional Spaces</span>
                </h1>
                <p class="text-slate-500 text-lg max-w-xl mb-10 leading-relaxed">
                    From creative studios to elegant ballrooms, find the perfect backdrop for your next big idea or celebration.
                </p>

                <!-- SEARCH BAR -->
                <div class="glass-card p-2 shadow-2xl border-indigo-50 max-w-2xl">
                    <form action="{{ route('spaces.index') }}" method="GET"
                          class="grid md:grid-cols-7 gap-2">
                        <div class="md:col-span-3 relative">
                            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                            <input type="text" name="search" placeholder="What are you looking for?"
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-indigo-500 bg-white/50 text-sm">
                        </div>
                        <div class="md:col-span-2 relative">
                            <i data-lucide="map-pin" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                            <input type="text" name="city" placeholder="Location"
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-indigo-500 bg-white/50 text-sm">
                        </div>
                        <button class="md:col-span-2 btn-primary !py-3">
                            <i data-lucide="search" class="w-4 h-4"></i>
                            Search
                        </button>
                    </form>
                </div>

                <div class="mt-8 flex items-center gap-4 text-sm text-slate-400">
                    <span>Popular:</span>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Offices</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Studios</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Event Halls</a>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="absolute -top-20 -right-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-60"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-purple-100 rounded-full blur-3xl opacity-60"></div>
                
                <div class="grid grid-cols-2 gap-4 animate-float">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=400" class="rounded-3xl shadow-2xl mt-12" alt="Office">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&q=80&w=400" class="rounded-3xl shadow-2xl" alt="Event">
                </div>
            </div>
        </div>
    </section>

    <!-- 🏷️ CATEGORIES -->
    <section class="reveal">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Browse by Category</h2>
            <p class="text-slate-500">Find the perfect space tailored to your needs</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 reveal-stagger">
            @php
                $categories = [
                    ['icon' => 'briefcase', 'name' => 'Work', 'color' => 'bg-blue-50 text-blue-600'],
                    ['icon' => 'music', 'name' => 'Parties', 'color' => 'bg-pink-50 text-pink-600'],
                    ['icon' => 'camera', 'name' => 'Photoshoot', 'color' => 'bg-purple-50 text-purple-600'],
                    ['icon' => 'mic', 'name' => 'Meetings', 'color' => 'bg-amber-50 text-amber-600'],
                    ['icon' => 'heart', 'name' => 'Weddings', 'color' => 'bg-rose-50 text-rose-600'],
                    ['icon' => 'palette', 'name' => 'Workshops', 'color' => 'bg-teal-50 text-teal-600'],
                ];
            @endphp

            @foreach($categories as $cat)
                <a href="#" class="group card !p-6 text-center hover:border-indigo-200">
                    <div class="w-12 h-12 {{ $cat['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i data-lucide="{{ $cat['icon'] }}"></i>
                    </div>
                    <h3 class="font-bold text-slate-800">{{ $cat['name'] }}</h3>
                </a>
            @endforeach
        </div>
    </section>

    <!-- ⭐ FEATURED SPACES -->
    <section>
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold mb-2">Featured Listings</h2>
                <p class="text-slate-500">Handpicked spaces for exceptional experiences</p>
            </div>

            <a href="{{ route('spaces.index') }}"
               class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:gap-3 transition-all">
                Explore All 
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 reveal-stagger">
            @forelse($featuredSpaces as $space)
                <div class="group card !p-0">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        @if($space->images->count())
                            <img src="{{ asset('storage/'.$space->images->first()->image_path) }}"
                                 class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                <i data-lucide="image" class="text-slate-300 w-12 h-12"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                <i data-lucide="star" class="w-3 h-3 inline fill-amber-400 text-amber-400 mr-1"></i> 4.9
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                {{ $space->title }}
                            </h3>
                            <span class="text-indigo-600 font-bold">₹{{ number_format($space->price) }}<span class="text-slate-400 text-xs font-normal">/hr</span></span>
                        </div>

                        <p class="text-slate-500 text-sm flex items-center gap-1 mb-6">
                            <i data-lucide="map-pin" class="w-3 h-3"></i>
                            {{ $space->city }}
                        </p>

                        <div class="flex items-center gap-4 py-4 border-t border-slate-50 text-slate-400 text-xs">
                            <span class="flex items-center gap-1"><i data-lucide="users" class="w-3 h-3"></i> 50 Guest</span>
                            <span class="flex items-center gap-1"><i data-lucide="maximize" class="w-3 h-3"></i> 1200 sqft</span>
                        </div>

                        <a href="{{ route('spaces.show', $space) }}"
                           class="btn-primary mt-4 w-full">
                            Book Now
                        </a>
                    </div>
                </div>
            @empty
                <!-- Empty state if no featured spaces -->
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="search-x" class="text-slate-300 w-10 h-10"></i>
                    </div>
                    <p class="text-slate-400">No featured spaces found at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 🚀 STATS SECTION -->
    <section class="bg-indigo-600 rounded-[40px] p-12 lg:p-20 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-400/20 rounded-full -ml-32 -mb-32 blur-3xl"></div>
        
        <div class="relative z-10 grid md:grid-cols-4 gap-12 text-center reveal-stagger">
            <div>
                <div class="text-4xl lg:text-5xl font-black mb-2">500+</div>
                <div class="text-indigo-100 font-medium">Unique Spaces</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-black mb-2">12k+</div>
                <div class="text-indigo-100 font-medium">Happy Bookings</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-black mb-2">4.8</div>
                <div class="text-indigo-100 font-medium">Average Rating</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-black mb-2">24/7</div>
                <div class="text-indigo-100 font-medium">Customer Support</div>
            </div>
        </div>
    </section>

    <!-- 🛠️ HOW IT WORKS -->
    <section>
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">How it Works</h2>
            <p class="text-slate-500">Three simple steps to your perfect space</p>
        </div>

        <div class="grid md:grid-cols-3 gap-12 relative reveal-stagger">
            <!-- Connector line (Desktop only) -->
            <div class="hidden md:block absolute top-24 left-1/4 right-1/4 h-0.5 bg-dashed border-t-2 border-indigo-100 border-dashed"></div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-white shadow-xl rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:-translate-y-2 transition-transform border border-indigo-50 relative z-10">
                    <i data-lucide="search" class="w-8 h-8 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">1. Find a Space</h3>
                <p class="text-slate-500 text-sm leading-relaxed px-6">
                    Browse our curated list of unique spaces and use filters to find exactly what you need.
                </p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-white shadow-xl rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:-translate-y-2 transition-transform border border-indigo-50 relative z-10">
                    <i data-lucide="calendar-check" class="w-8 h-8 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">2. Book Instantly</h3>
                <p class="text-slate-500 text-sm leading-relaxed px-6">
                    Select your date, time, and additional services. Book and pay securely in seconds.
                </p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-white shadow-xl rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:-translate-y-2 transition-transform border border-indigo-50 relative z-10">
                    <i data-lucide="sparkles" class="w-8 h-8 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">3. Enjoy Your Event</h3>
                <p class="text-slate-500 text-sm leading-relaxed px-6">
                    Show up and create memories. Our hosts ensure everything is perfect for your arrival.
                </p>
            </div>
        </div>
    </section>

    <!-- 🎯 CTA SECTION -->
    <section class="text-center py-20 px-10 bg-slate-900 text-white rounded-[40px] relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/50 to-transparent"></div>
        <div class="relative z-10 max-w-3xl mx-auto">
            <h2 class="text-4xl lg:text-5xl font-black mb-6">
                Turn Your Space Into <br>
                <span class="text-indigo-400">Extra Income</span>
            </h2>

            <p class="mb-10 text-slate-400 text-lg">
                Join thousands of hosts who are earning more by sharing their unique spaces with our community.
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    <form method="POST" action="{{ route('become.host') }}">
                        @csrf
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-indigo-600/30">
                            Start Hosting Today
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-indigo-600/30">
                        Create Your Account
                    </a>
                @endauth
                
                <a href="#" class="bg-white/10 hover:bg-white/20 backdrop-blur text-white px-10 py-4 rounded-2xl font-bold transition-all">
                    Learn How it Works
                </a>
            </div>
        </div>
    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        // Scroll to top button
        const scrollBtn = document.getElementById('scroll-top');
        if (scrollBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 400) {
                    scrollBtn.style.opacity = '1';
                    scrollBtn.style.transform = 'translateY(0)';
                } else {
                    scrollBtn.style.opacity = '0';
                    scrollBtn.style.transform = 'translateY(16px)';
                }
            });
            scrollBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>

@endsection