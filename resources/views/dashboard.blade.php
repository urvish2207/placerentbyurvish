@extends('layouts.app')

@section('content')

<div class="space-y-10">

    <!-- PAGE HEADER -->
    <div class="page-header px-8 py-10 reveal">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-bold tracking-widest mb-2 text-indigo-500 uppercase">Overview</p>
                <h1 class="text-3xl font-black" style="color: var(--text-primary)">
                    Welcome back, <span class="gradient-text">{{ explode(' ', auth()->user()->name)[0] }}</span> 👋
                </h1>
                <p class="mt-1 text-sm" style="color: var(--text-muted)">Here's what's happening with your spaces today.</p>
            </div>
            @if(auth()->user()->role === 'host')
                <a href="{{ route('host.spaces.index') }}" class="btn-primary self-start">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add New Space
                </a>
            @endif
        </div>
    </div>

    <!-- STATS GRID -->
    <div class="grid sm:grid-cols-3 gap-6 reveal-stagger">

        <div class="stat-card indigo">
            <div class="flex items-start justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center">
                    <i data-lucide="building-2" class="w-6 h-6 text-indigo-500"></i>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-600" style="background: rgba(99,102,241,0.1)">All time</span>
            </div>
            <p class="text-sm font-semibold mb-1" style="color: var(--text-muted)">Your Spaces</p>
            <h3 class="text-4xl font-black stat-number" style="color: var(--text-primary)">{{ $spaces }}</h3>
            <div class="mt-4 flex items-center gap-1 text-xs text-emerald-500 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                Active listings
            </div>
        </div>

        <div class="stat-card violet">
            <div class="flex items-start justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-violet-500/10 flex items-center justify-center">
                    <i data-lucide="calendar-check" class="w-6 h-6 text-violet-500"></i>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background: rgba(139,92,246,0.1); color: #8b5cf6">All time</span>
            </div>
            <p class="text-sm font-semibold mb-1" style="color: var(--text-muted)">Total Bookings</p>
            <h3 class="text-4xl font-black stat-number" style="color: var(--text-primary)">{{ $bookings }}</h3>
            <div class="mt-4 flex items-center gap-1 text-xs text-emerald-500 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                Completed bookings
            </div>
        </div>

        <div class="stat-card emerald">
            <div class="flex items-start justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center">
                    <i data-lucide="indian-rupee" class="w-6 h-6 text-emerald-500"></i>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background: rgba(16,185,129,0.1); color: #10b981">All time</span>
            </div>
            <p class="text-sm font-semibold mb-1" style="color: var(--text-muted)">Total Revenue</p>
            <h3 class="text-4xl font-black stat-number text-emerald-500">₹{{ number_format($revenue) }}</h3>
            <div class="mt-4 flex items-center gap-1 text-xs text-emerald-500 font-semibold">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                Net earnings
            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="card reveal">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold" style="color: var(--text-primary)">Revenue Trend</h3>
                <p class="text-sm" style="color: var(--text-muted)">Monthly revenue overview</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center" style="background: rgba(99,102,241,0.08)">
                <i data-lucide="line-chart" class="w-5 h-5 text-indigo-500"></i>
            </div>
        </div>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <!-- RECENT BOOKINGS -->
    <div class="card reveal">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold" style="color: var(--text-primary)">Recent Bookings</h3>
                <p class="text-sm" style="color: var(--text-muted)">Latest transactions</p>
            </div>
            <a href="{{ route('bookings.my') }}" class="text-sm font-bold text-indigo-500 hover:text-indigo-600 flex items-center gap-1">
                View all <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        @if($recentBookings->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background: var(--bg-secondary)">
                    <i data-lucide="calendar-x" class="w-8 h-8" style="color: var(--text-muted)"></i>
                </div>
                <p class="font-semibold" style="color: var(--text-secondary)">No bookings yet</p>
                <p class="text-sm mt-1" style="color: var(--text-muted)">Bookings will appear here once guests book your spaces.</p>
            </div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="w-full">
                    <thead>
                        <tr style="background: var(--bg-secondary)">
                            <th class="py-3 px-6 text-left text-xs font-bold tracking-wider" style="color: var(--text-muted)">GUEST</th>
                            <th class="py-3 px-4 text-left text-xs font-bold tracking-wider" style="color: var(--text-muted)">SPACE</th>
                            <th class="py-3 px-4 text-left text-xs font-bold tracking-wider" style="color: var(--text-muted)">AMOUNT</th>
                            <th class="py-3 px-4 text-left text-xs font-bold tracking-wider" style="color: var(--text-muted)">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr class="border-t hover:bg-indigo-50/5 transition-colors" style="border-color: var(--border)">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold" style="color: var(--text-primary)">{{ $booking->user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm" style="color: var(--text-secondary)">{{ $booking->space->title }}</td>
                                <td class="py-4 px-4 text-sm font-bold" style="color: var(--text-primary)">₹{{ number_format($booking->total_price) }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        {{ $booking->payment_status === 'paid' ? 'status-paid' : 'status-pending' }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.04)';
    const labelColor = isDark ? '#64748b' : '#94a3b8';

    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Revenue (₹)',
                data: @json($amounts),
                borderWidth: 2.5,
                borderColor: '#6366f1',
                tension: 0.45,
                fill: true,
                backgroundColor: (context) => {
                    const gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 280);
                    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
                    gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');
                    return gradient;
                },
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e1e2a' : '#fff',
                    titleColor: isDark ? '#e2e8f0' : '#1e293b',
                    bodyColor: '#6366f1',
                    borderColor: 'rgba(99,102,241,0.2)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                    callbacks: {
                        label: (ctx) => ` ₹${ctx.parsed.y.toLocaleString()}`
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: gridColor },
                    ticks: { color: labelColor, font: { family: 'Outfit', size: 12 } }
                },
                y: {
                    grid: { color: gridColor },
                    ticks: {
                        color: labelColor,
                        font: { family: 'Outfit', size: 12 },
                        callback: (val) => '₹' + val.toLocaleString()
                    }
                }
            }
        }
    });
});
</script>

@endsection
