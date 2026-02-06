<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    {{-- Header --}}
    <div class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('dashboard_overview') }}</h1>
                <p class="text-sm text-gray-600 mt-0.5">{{ trans_db('dashboard_welcome') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    📅 {{ trans_db('today') }}
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    📆 {{ trans_db('custom_date') }}
                </button>
            </div>
        </div>
    </div>

    <div class="p-6">
        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            {{-- Total Bookings --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide mb-1">{{ trans_db('total_bookings') }}</p>
                        <div class="flex items-baseline space-x-2">
                            <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_bookings'] }}</h3>
                            @if($stats['booking_growth'] >= 0)
                                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded">↗{{ $stats['booking_growth'] }}%</span>
                            @else
                                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded">↘{{ abs($stats['booking_growth']) }}%</span>
                            @endif
                        </div>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Occupied Rooms --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide mb-1">{{ trans_db('occupied_rooms') }}</p>
                        <div class="flex items-baseline space-x-2">
                            <h3 class="text-3xl font-bold text-gray-900">{{ $stats['occupied_rooms'] }}</h3>
                            @if($stats['occupied_growth'] >= 0)
                                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded">↗{{ $stats['occupied_growth'] }}%</span>
                            @else
                                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded">↘{{ abs($stats['occupied_growth']) }}%</span>
                            @endif
                        </div>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Available Rooms --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide mb-1">{{ trans_db('available_rooms') }}</p>
                        <div class="flex items-baseline space-x-2">
                            <h3 class="text-3xl font-bold text-gray-900">{{ $stats['available_rooms'] }}</h3>
                            @if($stats['available_growth'] >= 0)
                                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded">↗{{ $stats['available_growth'] }}%</span>
                            @else
                                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded">↘{{ abs($stats['available_growth']) }}%</span>
                            @endif
                        </div>
                    </div>
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Daily Occupancy Trends --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ trans_db('daily_occupancy_trends') }}</h2>
                        <p class="text-sm text-gray-600 mt-0.5">{{ trans_db('occupancy_subtitle') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ round($stats['avg_occupancy'], 1) }}%</div>
                        <div class="text-xs text-gray-600">{{ trans_db('average') }} <span class="text-green-600 font-semibold">↗ 2.4%</span></div>
                    </div>
                </div>
                
                {{-- Dynamic Chart --}}
                <div class="relative h-64 bg-gradient-to-br from-orange-50 via-blue-50 to-blue-100 rounded-lg flex items-end justify-around p-4">
                    @foreach($stats['occupancy_trend'] as $trend)
                        <div class="text-center group relative h-full flex flex-col justify-end">
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ $trend['percentage'] }}%
                            </div>
                            <div 
                                style="height: {{ $trend['percentage'] }}%" 
                                class="w-12 {{ $trend['percentage'] > 80 ? 'bg-gradient-to-t from-blue-600 to-blue-400' : 'bg-gradient-to-t from-orange-400 to-orange-300' }} rounded-t-lg mb-2 transition-all duration-500 hover:brightness-110"
                            ></div>
                            <span class="text-xs text-gray-600">{{ $trend['day'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ trans_db('quick_actions') }}</h2>
                
                <div class="grid grid-cols-2 gap-3">
                    <a href="/booking/counter" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg hover:shadow-lg transition text-white">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold">{{ trans_db('new_booking') }}</span>
                    </a>

                    <a href="/booking/counter" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg hover:shadow-lg transition text-white">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold">{{ trans_db('register_guest') }}</span>
                    </a>

                    <a href="/rooms" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg hover:shadow-lg transition text-white">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold">{{ trans_db('room_status') }}</span>
                    </a>

                    <a href="/cash/ledger" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg hover:shadow-lg transition text-white">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold">{{ trans_db('view_reports') }}</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Arrivals & Recent Bookings --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            {{-- Recent Arrivals --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">{{ trans_db('recent_arrivals') }}</h2>
                    <a href="/rooms" class="text-sm font-medium text-blue-600 hover:text-blue-700">{{ trans_db('view_all') }}</a>
                </div>

                <div class="space-y-3">
                    @forelse($recent_bookings as $booking)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-blue-600">{{ strtoupper(substr($booking->guest->first_name ?? 'G', 0, 1) . substr($booking->guest->last_name ?? 'U', 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $booking->guest->first_name ?? 'Guest' }} {{ $booking->guest->last_name ?? '' }}</p>
                                    <p class="text-xs text-gray-600">
                                        @if($booking->rooms->isNotEmpty())
                                            {{ trans_db('room') }} {{ $booking->rooms->first()->room_number }} • {{ $booking->rooms->first()->roomCategory->name ?? 'Standard' }}
                                        @else
                                            {{ trans_db('no_room_assigned') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if($booking->status === 'checked_in')
                                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">{{ trans_db('checked_in_status') }}</span>
                            @elseif($booking->status === 'confirmed')
                                <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">{{ trans_db('confirmed') }}</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded-full">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </div>
                    @empty
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-blue-600">AS</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Anil Sharma</p>
                                    <p class="text-xs text-gray-600">Room 204 • Deluxe</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Checked-In</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-purple-600">RJ</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Rajesh Joshi</p>
                                    <p class="text-xs text-gray-600">Room 305 • Standard</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-green-600">MK</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Meera Kumar</p>
                                    <p class="text-xs text-gray-600">Room 108 • Suite</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Checked-In</span>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Payments --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">{{ trans_db('recent_payments') }}</h2>
                    <a href="/cash/ledger" class="text-sm font-medium text-blue-600 hover:text-blue-700">{{ trans_db('view_all') }}</a>
                </div>

                <div class="space-y-3">
                    @forelse($recent_payments as $payment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $payment->booking->guest->first_name ?? 'Guest' }} {{ $payment->booking->guest->last_name ?? '' }}</p>
                                <p class="text-xs text-gray-600">{{ $payment->created_at->format('d M, h:i A') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">₹{{ number_format($payment->amount, 0) }}</p>
                                <p class="text-xs text-gray-600">{{ ucfirst($payment->payment_mode ?? 'Cash') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Anil Sharma</p>
                                <p class="text-xs text-gray-600">Today, 10:30 AM</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">₹2,500</p>
                                <p class="text-xs text-gray-600">Cash</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Rajesh Joshi</p>
                                <p class="text-xs text-gray-600">Today, 09:15 AM</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">₹1,800</p>
                                <p class="text-xs text-gray-600">UPI</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Meera Kumar</p>
                                <p class="text-xs text-gray-600">Yesterday, 04:45 PM</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">₹3,200</p>
                                <p class="text-xs text-gray-600">Card</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
