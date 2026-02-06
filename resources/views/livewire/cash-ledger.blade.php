<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('cash_ledger_payments') }}</h1>
                    <p class="text-gray-600 text-sm mt-0.5">{{ trans_db('track_payments_collections') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ trans_db('date') }}</label>
                <input type="date" wire:model.live="date_filter"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ trans_db('payment_mode') }}</label>
                <select wire:model.live="payment_mode_filter"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">{{ trans_db('all_modes') }}</option>
                    <option value="cash">{{ trans_db('cash') }}</option>
                    <option value="online">{{ trans_db('online') }}</option>
                    <option value="upi">{{ trans_db('upi') }}</option>
                    <option value="card">{{ trans_db('card') }}</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-600 font-medium">{{ trans_db('total_collection') }}</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">₹{{ number_format($summary['total'] ?? 0, 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $summary['count'] ?? 0 }} {{ trans_db('transactions') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <p class="text-sm text-gray-600 font-medium">{{ trans_db('cash') }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">₹{{ number_format($summary['cash'] ?? 0, 0) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <p class="text-sm text-gray-600 font-medium">{{ trans_db('online') }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">₹{{ number_format($summary['online'] ?? 0, 0) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <p class="text-sm text-gray-600 font-medium">{{ trans_db('upi') }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">₹{{ number_format($summary['upi'] ?? 0, 0) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <p class="text-sm text-gray-600 font-medium">{{ trans_db('card') }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">₹{{ number_format($summary['card'] ?? 0, 0) }}</p>
        </div>
    </div>

    {{-- Payments Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            {{ trans_db('time') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            {{ trans_db('guest') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            {{ trans_db('booking_id') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            {{ trans_db('mode') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            {{ trans_db('transaction_id') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            {{ trans_db('amount') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $payment->created_at->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $payment->booking->guest->first_name }}
                                    {{ $payment->booking->guest->last_name }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $payment->booking->guest->mobile_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                #{{ $payment->booking_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 text-xs font-medium rounded-full 
                                            {{ $payment->payment_mode === 'cash' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $payment->payment_mode === 'online' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $payment->payment_mode === 'upi' ? 'bg-purple-100 text-purple-700' : '' }}
                                            {{ $payment->payment_mode === 'card' ? 'bg-indigo-100 text-indigo-700' : '' }}">
                                    {{ strtoupper($payment->payment_mode) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $payment->transaction_id ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span
                                    class="text-lg font-bold {{ $payment->amount < 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $payment->amount < 0 ? '-' : '' }}₹{{ number_format(abs($payment->amount), 0) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-gray-500 font-medium">{{ trans_db('no_payments_found') }}</p>
                                <p class="text-gray-400 text-sm mt-1">{{ trans_db('try_different_date_mode') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>