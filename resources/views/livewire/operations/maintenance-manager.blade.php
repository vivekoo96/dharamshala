<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('maintenance_log') }}</h1>
            <p class="text-sm text-gray-600 mt-1">{{ trans_db('maintenance_subtitle') }}</p>
        </div>
        <button wire:click.prevent="create" wire:loading.attr="disabled"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg wire:loading.remove wire:target="create" class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <svg wire:loading wire:target="create" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span wire:loading.remove wire:target="create">{{ trans_db('report_issue') }}</span>
            <span wire:loading wire:target="create">{{ trans_db('loading') }}...</span>
        </button>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ trans_db('search') }}</label>
                <input wire:model.live="search" type="text"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="{{ trans_db('search_maintenance_placeholder') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ trans_db('status') }}</label>
                <select wire:model.live="statusFilter"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">{{ trans_db('all_statuses') }}</option>
                    <option value="pending">{{ trans_db('pending') }}</option>
                    <option value="in_progress">{{ trans_db('in_progress') }}</option>
                    <option value="resolved">{{ trans_db('resolved') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ trans_db('priority') }}</label>
                <select wire:model.live="priorityFilter"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">{{ trans_db('all_priorities') }}</option>
                    <option value="low">{{ trans_db('low') }}</option>
                    <option value="medium">{{ trans_db('medium') }}</option>
                    <option value="high">{{ trans_db('high') }}</option>
                    <option value="critical">{{ trans_db('critical') }}</option>
                </select>
            </div>
        </div>
    </div>

    {{-- List --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <ul class="divide-y divide-gray-200">
            @forelse($requests as $request)
                    <li class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0 pr-4">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-sm font-bold text-gray-900 truncate">
                                        {{ trans_db('room') }} {{ $request->room->room_number ?? 'N/A' }}
                                    </h3>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                                    {{ $request->priority === 'critical' ? 'bg-red-100 text-red-800' :
                ($request->priority === 'high' ? 'bg-orange-100 text-orange-800' :
                    ($request->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($request->priority) }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                                    {{ $request->status === 'resolved' ? 'bg-green-100 text-green-800' :
                ($request->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $request->issue_description }}</p>
                                <div class="flex items-center text-xs text-gray-500 gap-4">
                                    <span><span class="font-medium">Reported by:</span> {{ $request->reported_by }}</span>
                                    <span><span class="font-medium">Date:</span>
                                        {{ $request->created_at->format('M d, Y H:i') }}</span>
                                    @if($request->resolved_at)
                                        <span class="text-green-600"><span class="font-medium">Resolved:</span>
                                            {{ $request->resolved_at->format('M d, Y H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2">
                                @if($request->status !== 'resolved')
                                    <button wire:click="markResolved({{ $request->id }})"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200">
                                        {{ trans_db('resolve') }}
                                    </button>
                                @endif
                                <button wire:click="edit({{ $request->id }})"
                                    class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    {{ trans_db('edit') }}
                                </button>
                            </div>
                        </div>
                    </li>
            @empty
                <li class="p-8 text-center text-gray-500">
                    No maintenance requests found.
                </li>
            @endforelse
        </ul>
        @if($requests->hasPages())
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal - Premium Redesign --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" aria-hidden="true"
                    wire:click="$set('showModal', false)" x-show="true" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full ring-1 ring-black ring-opacity-5">

                    {{-- Header --}}
                    <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900" id="modal-title">
                            {{ $requestId ? trans_db('edit_request') : trans_db('report_new_issue') }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-500 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white px-6 pt-6 pb-6 space-y-5">
                        {{-- Room Selection --}}
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-1">{{ trans_db('affected_room') }}</label>
                            <div class="relative">
                                <select wire:model="room_id"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white appearance-none transition-colors">
                                    <option value="">{{ trans_db('select_room') }}</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('room_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Issue Description --}}
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-1">{{ trans_db('issue_description') }}</label>
                            <textarea wire:model="issue_description" rows="3"
                                placeholder="{{ trans_db('issue_description_placeholder') }}"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors"></textarea>
                            @error('issue_description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Priority & Status Grid --}}
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Priority Level</label>
                                <div class="relative">
                                    <select wire:model="priority"
                                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white appearance-none transition-colors">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Current Status</label>
                                <div class="relative">
                                    <select wire:model="status"
                                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white appearance-none transition-colors">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                        <button wire:click.prevent="save" wire:loading.attr="disabled"
                            class="inline-flex justify-center items-center w-full sm:w-auto px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="save">
                                {{ trans_db('save_request') }}
                            </span>
                            <span wire:loading wire:target="save" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ trans_db('saving') }}...
                            </span>
                        </button>
                        <button wire:click="$set('showModal', false)" type="button"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900 font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all shadow-sm">
                            {{ trans_db('cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Toast Notification --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif
</div>