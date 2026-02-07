<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('collection_reports') }}</h1>
                    <p class="text-gray-600 text-sm mt-0.5">{{ trans_db('shift_daily_analysis') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ trans_db('from_date') }}</label>
                <input type="date" wire:model.live="date_from"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ trans_db('to_date') }}</label>
                <input type="date" wire:model.live="date_to"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ trans_db('shift') }}</label>
                <select wire:model.live="shift"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">{{ trans_db('all_shifts') }}</option>
                    <option value="morning">{{ trans_db('morning_shift') }} (6 AM - 2 PM)</option>
                    <option value="evening">{{ trans_db('evening_shift') }} (2 PM - 10 PM)</option>
                    <option value="night">{{ trans_db('night_shift') }} (10 PM - 6 AM)</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="loadReport"
                    class="w-full px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    {{ trans_db('generate_report') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Collection Summary --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ trans_db('payment_collection_summary') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div class="bg-indigo-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">Gross Revenue</p>
                <p class="text-2xl font-bold mt-1">₹{{ number_format($summary['total_gross'] ?? 0, 0) }}</p>
            </div>
            <div class="bg-orange-500 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">Total Discounts</p>
                <p class="text-2xl font-bold mt-1">₹{{ number_format($summary['total_discount'] ?? 0, 0) }}</p>
            </div>
            <div class="bg-emerald-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">Net Collection</p>
                <p class="text-2xl font-bold mt-1">₹{{ number_format($summary['total_collection'] ?? 0, 0) }}</p>
                <p class="text-xs opacity-75 mt-1">{{ $summary['total_transactions'] ?? 0 }} Transactions</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('cash') }}</p>
                <p class="text-xl font-bold text-gray-900 mt-1">₹{{ number_format($summary['cash'] ?? 0, 0) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('online') }}</p>
                <p class="text-xl font-bold text-gray-900 mt-1">₹{{ number_format($summary['online'] ?? 0, 0) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('upi') }}</p>
                <p class="text-xl font-bold text-gray-900 mt-1">₹{{ number_format($summary['upi'] ?? 0, 0) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('card') }}</p>
                <p class="text-xl font-bold text-gray-900 mt-1">₹{{ number_format($summary['card'] ?? 0, 0) }}</p>
            </div>
            <div class="bg-blue-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">{{ trans_db('avg_transaction') }}</p>
                <p class="text-xl font-bold mt-1">
                    ₹{{ $summary['total_transactions'] > 0 ? number_format($summary['total_collection'] / $summary['total_transactions'], 0) : 0 }}
                </p>
            </div>
        </div>
    </div>

    {{-- Bookings Summary --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ trans_db('bookings_summary') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-blue-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">{{ trans_db('total_bookings') }}</p>
                <p class="text-3xl font-bold mt-1">{{ $bookings_summary['total_bookings'] ?? 0 }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('confirmed') }}</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $bookings_summary['confirmed'] ?? 0 }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('checked_in') }}</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $bookings_summary['checked_in'] ?? 0 }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('checked_out') }}</p>
                <p class="text-2xl font-bold text-gray-600 mt-1">{{ $bookings_summary['checked_out'] ?? 0 }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">{{ trans_db('cancelled') }}</p>
                <p class="text-2xl font-bold text-red-600 mt-1">{{ $bookings_summary['cancelled'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Export Options --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ trans_db('export_report') }}</h2>
        <div class="flex flex-wrap gap-3">
            <button wire:click="exportPDF"
                class="px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                    </path>
                </svg>
                {{ trans_db('export_as_pdf') }}
            </button>
            <button wire:click="exportCSV"
                class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                {{ trans_db('export_as_excel') }}
            </button>
            <button onclick="window.print()"
                class="px-6 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                {{ trans_db('print_report') }}
            </button>
        </div>
    </div>
</div>