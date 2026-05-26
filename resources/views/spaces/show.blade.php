@extends('layouts.app')

@section('content')

<!-- SWIPER CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<div class="space-y-10 pb-10">

    <!-- BACK BUTTON -->
    <div class="reveal">
        <a href="{{ route('spaces.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold transition-colors hover:text-indigo-500" style="color: var(--text-secondary)">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Spaces
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">

        <!-- LEFT: MAIN CONTENT -->
        <div class="lg:col-span-2 space-y-8">

            <!-- IMAGE GALLERY -->
            @if($space->images->count())
                <div class="reveal">
                    @if($space->images->count() === 1)
                        <div class="rounded-3xl overflow-hidden aspect-[16/9]">
                            <img src="{{ asset('storage/'.$space->images->first()->image_path) }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="swiper mySwiper rounded-3xl overflow-hidden">
                            <div class="swiper-wrapper">
                                @foreach($space->images as $image)
                                    <div class="swiper-slide">
                                        <div class="aspect-[16/9]">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next !text-white !w-10 !h-10 !rounded-xl !bg-white/20 !backdrop-blur"></div>
                            <div class="swiper-button-prev !text-white !w-10 !h-10 !rounded-xl !bg-white/20 !backdrop-blur"></div>
                            <div class="swiper-pagination"></div>
                        </div>

                        @if($space->images->count() > 1)
                            <div class="grid grid-cols-4 gap-3 mt-3">
                                @foreach($space->images->take(4) as $i => $img)
                                    <div class="rounded-2xl overflow-hidden aspect-square cursor-pointer swiper-thumb-{{ $i }} ring-2 ring-transparent hover:ring-indigo-400 transition-all">
                                        <img src="{{ asset('storage/'.$img->image_path) }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            @else
                <div class="reveal rounded-3xl overflow-hidden aspect-[16/9]" style="background: var(--bg-secondary)">
                    <div class="w-full h-full flex items-center justify-center">
                        <i data-lucide="image" class="w-16 h-16" style="color: var(--text-muted)"></i>
                    </div>
                </div>
            @endif

            <!-- SPACE INFO -->
            <div class="reveal">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-3xl font-black mb-2" style="color: var(--text-primary)">{{ $space->title }}</h1>
                        <p class="flex items-center gap-1.5 text-sm" style="color: var(--text-muted)">
                            <i data-lucide="map-pin" class="w-4 h-4 text-indigo-400"></i>
                            {{ $space->city }}, {{ $space->country }}
                        </p>
                    </div>
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl" style="background: rgba(99,102,241,0.08)">
                        <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                        <span class="text-sm font-bold text-indigo-600">4.9</span>
                        <span class="text-xs" style="color: var(--text-muted)">(128 reviews)</span>
                    </div>
                </div>

                <!-- QUICK STATS -->
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="card !p-4 text-center">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mx-auto mb-2" style="background: rgba(99,102,241,0.08)">
                            <i data-lucide="users" class="w-5 h-5 text-indigo-500"></i>
                        </div>
                        <p class="text-lg font-black" style="color: var(--text-primary)">{{ $space->capacity }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">Max Guests</p>
                    </div>

                    <div class="card !p-4 text-center">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2" style="background: rgba(139,92,246,0.08)">
                            <i data-lucide="user-check" class="w-5 h-5 text-violet-500"></i>
                        </div>
                        <p class="text-lg font-black" style="color: var(--text-primary)">{{ $space->min_capacity }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">Min Guests</p>
                    </div>

                    <div class="card !p-4 text-center">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2" style="background: rgba(16,185,129,0.08)">
                            <i data-lucide="users-2" class="w-5 h-5 text-emerald-500"></i>
                        </div>
                        <p class="text-lg font-black text-emerald-500">{{ $remaining }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">Remaining</p>
                    </div>
                </div>

                <!-- AVAILABLE SLOTS -->
                @php
                    $slots = $space->available_slots;
                    if (is_string($slots)) $slots = json_decode($slots, true);
                    if (!is_array($slots)) $slots = [];
                @endphp

                @if(count($slots))
                    <div class="mb-8">
                        <h3 class="text-sm font-bold mb-3 tracking-wider uppercase" style="color: var(--text-muted)">Available Time Slots</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($slots as $slot)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-semibold" style="background: rgba(99,102,241,0.08); color: #6366f1">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                    {{ ucfirst(str_replace('_', ' ', $slot)) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- DESCRIPTION -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-4" style="color: var(--text-primary)">About This Space</h3>
                    <p class="leading-relaxed" style="color: var(--text-secondary)">{{ $space->description }}</p>
                </div>
            </div>

            <!-- REVIEWS -->
            <div class="reveal">
                <h3 class="text-xl font-bold mb-6" style="color: var(--text-primary)">
                    Guest Reviews
                    <span class="text-base font-normal ml-2" style="color: var(--text-muted)">({{ $space->reviews->count() }})</span>
                </h3>

                @auth
                    <div class="card !p-6 mb-6" style="border: 1px solid rgba(99,102,241,0.15)">
                        <h4 class="font-bold mb-4 text-sm" style="color: var(--text-primary)">Leave a Review</h4>
                        <form method="POST" action="{{ route('reviews.store', $space) }}" class="space-y-4">
                            @csrf
                            <div class="space-y-1">
                                <label class="text-xs font-bold tracking-wider uppercase" style="color: var(--text-muted)">Rating</label>
                                <select name="rating" class="input-field">
                                    <option value="">Select Rating</option>
                                    @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}">{{ str_repeat('⭐', $i) }} {{ $i }}/5</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold tracking-wider uppercase" style="color: var(--text-muted)">Your Comment</label>
                                <textarea name="comment" class="input-field !h-28 resize-none" placeholder="Share your experience..."></textarea>
                            </div>
                            <button class="btn-primary !py-3" type="submit">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                Submit Review
                            </button>
                        </form>
                    </div>
                @endauth

                @forelse($space->reviews as $review)
                    <div class="card !p-5 mb-4">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm" style="color: var(--text-primary)">{{ $review->user->name }}</p>
                                <div class="flex items-center gap-1 mt-0.5">
                                    @for($i=1; $i<=5; $i++)
                                        <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                    <span class="text-xs ml-1 font-semibold" style="color: var(--text-muted)">{{ $review->rating }}/5</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed pl-13" style="color: var(--text-secondary)">{{ $review->comment }}</p>
                    </div>
                @empty
                    <div class="card !p-8 text-center">
                        <i data-lucide="message-square" class="w-10 h-10 mx-auto mb-3" style="color: var(--text-muted)"></i>
                        <p class="font-semibold" style="color: var(--text-secondary)">No reviews yet</p>
                        <p class="text-sm" style="color: var(--text-muted)">Be the first to share your experience!</p>
                    </div>
                @endforelse
            </div>

        </div>

        <!-- RIGHT: BOOKING CARD (STICKY) -->
        <div class="lg:col-span-1">
            <div class="card !p-6 sticky top-24 reveal-right">
                <!-- PRICE -->
                <div class="mb-6">
                    <p class="text-3xl font-black" style="color: var(--text-primary)">
                        ₹{{ number_format($space->price) }}
                        <span class="text-base font-normal" style="color: var(--text-muted)">/ day</span>
                    </p>
                    <div class="flex items-center gap-1 mt-1">
                        <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                        <span class="text-sm font-semibold" style="color: var(--text-primary)">4.9</span>
                        <span class="text-sm" style="color: var(--text-muted)">· 128 reviews</span>
                    </div>
                </div>

                <hr class="mb-6" style="border-color: var(--border)">

                <!-- BOOK NOW -->
                @auth
                    <a href="{{ route('bookings.create', $space) }}"
                       class="btn-primary w-full !py-4 mb-4">
                        <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                        Book This Space
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full !py-4 mb-4">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        Login to Book
                    </a>
                @endauth

                <p class="text-xs text-center" style="color: var(--text-muted)">You won't be charged until confirmed</p>

                <hr class="my-5" style="border-color: var(--border)">

                <!-- HIGHLIGHTS -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm" style="color: var(--text-secondary)">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0" style="background: rgba(16,185,129,0.08)">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
                        </div>
                        <span>Secure & encrypted payment</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm" style="color: var(--text-secondary)">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(99,102,241,0.08)">
                            <i data-lucide="zap" class="w-4 h-4 text-indigo-500"></i>
                        </div>
                        <span>Instant booking confirmation</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm" style="color: var(--text-secondary)">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.08)">
                            <i data-lucide="headphones" class="w-4 h-4 text-amber-500"></i>
                        </div>
                        <span>24/7 guest support</span>
                    </div>
                </div>

                <hr class="my-5" style="border-color: var(--border)">

                <!-- HOST INFO -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr($space->user->name ?? 'H', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs" style="color: var(--text-muted)">Hosted by</p>
                        <p class="font-bold text-sm" style="color: var(--text-primary)">{{ $space->user->name ?? 'Host' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- SWIPER JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    if (document.querySelector('.mySwiper')) {
        new Swiper('.mySwiper', {
            loop: true,
            effect: 'slide',
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
});
</script>

@endsection