@extends('layouts.app')

@section('content')

<div class="space-y-12">

    <!-- PAGE HEADER -->
    <div class="relative py-12 rounded-[40px] bg-indigo-50 overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-100 rounded-full -mr-32 -mt-32 blur-3xl opacity-50"></div>
        <div class="relative z-10 px-10 text-center lg:text-left">
            <h1 class="text-4xl lg:text-5xl font-black text-slate-800 mb-4">
                Explore <span class="text-indigo-600">Perfect Spaces</span>
            </h1>
            <p class="text-slate-500 text-lg max-w-2xl leading-relaxed">
                Browse through our wide selection of venues and find the one that fits your event perfectly.
            </p>
        </div>
    </div>

    <div class="grid lg:grid-cols-4 gap-10">
        
        <!-- SIDEBAR FILTERS -->
        <aside class="space-y-8">
            <div class="card !p-8 sticky top-24">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <i data-lucide="filter" class="w-5 h-5 text-indigo-600"></i>
                    Filters
                </h2>

                <form method="GET" action="{{ route('spaces.index') }}" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Search</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                            <input type="text" name="search" placeholder="Event hall, studio..." 
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 text-sm transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">City</label>
                        <div class="relative">
                            <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                            <input type="text" name="city" placeholder="All Cities" 
                                   value="{{ request('city') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 text-sm transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Max Budget (₹)</label>
                        <div class="relative">
                            <i data-lucide="indian-rupee" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                            <input type="number" name="price" placeholder="Any Price" 
                                   value="{{ request('price') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 text-sm transition-all">
                        </div>
                    </div>

                    <button class="btn-primary w-full py-4 mt-2">
                        Apply Filters
                    </button>

                    @if(request()->anyFilled(['search', 'city', 'price']))
                        <a href="{{ route('spaces.index') }}" class="block text-center text-sm text-slate-400 hover:text-red-500 transition-colors">
                            Clear all filters
                        </a>
                    @endif
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-3">
            @if($spaces->isEmpty())
                <div class="card text-center py-24 flex flex-col items-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                        <i data-lucide="search-x" class="text-slate-300 w-12 h-12"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">No spaces found</h3>
                    <p class="text-slate-500 max-w-xs mx-auto">We couldn't find any spaces matching your current filters. Try adjusting them!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($spaces as $space)
                        <div class="group card !p-0">
                            <div class="relative overflow-hidden aspect-[16/10]">
                                @if($space->images->count())
                                    <img src="{{ asset('storage/'.$space->images->first()->image_path) }}"
                                         class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                        <i data-lucide="image" class="w-12 h-12"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-lg shadow-indigo-200">
                                        Featured
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                        {{ $space->title }}
                                    </h3>
                                    <span class="text-indigo-600 font-bold whitespace-nowrap">₹{{ number_format($space->price) }}<span class="text-slate-400 text-xs font-normal">/hr</span></span>
                                </div>

                                <p class="text-slate-500 text-sm flex items-center gap-1 mb-6">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-indigo-400"></i>
                                    {{ $space->city }}
                                </p>

                                <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                    <div class="flex items-center gap-3 text-slate-400 text-xs">
                                        <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> 50+</span>
                                        <span class="flex items-center gap-1"><i data-lucide="maximize" class="w-4 h-4"></i> 1500 sqft</span>
                                    </div>
                                    <a href="{{ route('spaces.show', $space) }}" class="text-indigo-600 font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all">
                                        Details <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $spaces->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>

@endsection
