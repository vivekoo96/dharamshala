<div>
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('attendance_scanner') }}</h1>
        <p class="text-sm text-gray-600 mt-1">{{ trans_db('attendance_subtitle') }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="text-xs font-semibold text-gray-500 uppercase">{{ trans_db('total_active_staff') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="text-xs font-semibold text-green-600 uppercase">{{ trans_db('present_today') }}</div>
            <div class="text-2xl font-bold text-green-700 mt-1">{{ $stats['present'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="text-xs font-semibold text-red-600 uppercase">{{ trans_db('absent_not_checked_in') }}</div>
            <div class="text-2xl font-bold text-red-700 mt-1">{{ $stats['absent'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Scanner Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">{{ trans_db('scan_qr_code') }}</h2>

            {{-- Status Message --}}
            @if($message)
                <div
                    class="mb-4 p-4 rounded-md {{ $scanResult === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : ($scanResult === 'warning' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 'bg-red-50 text-red-700 border border-red-200') }}">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if($scanResult === 'success')
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            @elseif($scanResult === 'warning')
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="processScan" class="mb-6">
                <div>
                    <label for="qr_code"
                        class="block text-sm font-medium text-gray-700">{{ trans_db('qr_code_input') }}</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" wire:model="qrCodeInput" id="qr_code"
                            class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                            placeholder="{{ trans_db('scan_placeholder') }}" autofocus>
                        <button type="submit"
                            class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <span>{{ trans_db('submit') }}</span>
                        </button>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">{{ trans_db('scanner_focus_hint') }}</p>
                </div>
            </form>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-900 mb-4">{{ trans_db('manual_check_title') }}</h3>
                <div class="flex gap-2">
                    <select wire:model="manualStaffId"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">{{ trans_db('select_staff_member') }}</option>
                        @foreach($allStaff as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }} ({{ ucfirst($staff->role) }})</option>
                        @endforeach
                    </select>
                    <button wire:click="manualCheckIn"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ trans_db('mark') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">{{ trans_db('todays_activity') }}</h2>
            <div class="flow-root">
                <ul class="-mb-8">
                    @forelse($recentActivity as $activity)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                        aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span
                                            class="h-8 w-8 rounded-full {{ $activity->check_out_time ? 'bg-gray-400' : 'bg-green-500' }} flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                <span class="font-medium text-gray-900">{{ $activity->staff->name }}</span>
                                                @if($activity->check_out_time)
                                                    {{ trans_db('checked_out') }}
                                                @else
                                                    {{ trans_db('checked_in') }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time
                                                datetime="{{ $activity->updated_at }}">{{ $activity->updated_at->format('H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-sm text-gray-500">{{ trans_db('no_activity_today') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>