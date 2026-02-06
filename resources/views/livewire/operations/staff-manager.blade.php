<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('staff_management') }}</h1>
            <p class="text-sm text-gray-600 mt-1">{{ trans_db('staff_subtitle') }}</p>
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
            <span wire:loading.remove wire:target="create">{{ trans_db('add_new_staff') }}</span>
            <span wire:loading wire:target="create">{{ trans_db('loading') }}...</span>
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="text-xs font-semibold text-gray-500 uppercase">{{ trans_db('total_staff') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Staff::count() }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="text-xs font-semibold text-gray-500 uppercase">{{ trans_db('active') }}</div>
            <div class="text-2xl font-bold text-green-600 mt-1">
                {{ \App\Models\Staff::where('status', 'active')->count() }}
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="text-xs font-semibold text-gray-500 uppercase">{{ trans_db('managers') }}</div>
            <div class="text-2xl font-bold text-blue-600 mt-1">
                {{ \App\Models\Staff::where('role', 'manager')->count() }}
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="text-xs font-semibold text-gray-500 uppercase">{{ trans_db('staff_other') }}</div>
            <div class="text-2xl font-bold text-gray-600 mt-1">
                {{ \App\Models\Staff::where('role', '!=', 'manager')->count() }}
            </div>
        </div>
    </div>

    {{-- Search and Filter --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-4 border-b border-gray-200">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live="search" type="text"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                    placeholder="{{ trans_db('search_staff_placeholder') }}">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ trans_db('name_role') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ trans_db('contact') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ trans_db('status') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ trans_db('qr_code') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ trans_db('actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($staffMembers as $staff)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                            {{ substr($staff->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $staff->name }}</div>
                                        <div class="text-xs text-gray-500 capitalize">{{ $staff->role }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $staff->phone ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $staff->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $staff->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $staff->qr_code ?? 'None' }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $staff->id }})"
                                    class="text-blue-600 hover:text-blue-900 mr-3">{{ trans_db('edit') }}</button>
                                <button wire:click="delete({{ $staff->id }})" class="text-red-600 hover:text-red-900"
                                    onclick="confirm('{{ trans_db('are_you_sure') }}') || event.stopImmediatePropagation()">{{ trans_db('delete') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                {{ trans_db('no_staff_found_hint') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staffMembers->hasPages())
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $staffMembers->links() }}
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
                            {{ $isEditing ? trans_db('edit_staff_member') : trans_db('add_new_staff_member') }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-500 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white px-6 pt-6 pb-6 space-y-5">
                        {{-- Name --}}
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-1">{{ trans_db('full_name') }}</label>
                            <input type="text" wire:model="name" placeholder="{{ trans_db('name_placeholder') }}"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Role --}}
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-1">{{ trans_db('role_permissions') }}</label>
                            <div class="relative">
                                <select wire:model="role"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white appearance-none transition-colors">
                                    <option value="manager">Manager</option>
                                    <option value="reception">Reception</option>
                                    <option value="housekeeping">Housekeeping</option>
                                    <option value="security">Security</option>
                                    <option value="staff">Staff (General)</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Phone & Email Grid --}}
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-700 mb-1">{{ trans_db('phone_number') }}</label>
                                <input type="text" wire:model="phone" placeholder="{{ trans_db('phone_placeholder') }}"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                                @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-700 mb-1">{{ trans_db('email_address') }}</label>
                                <input type="email" wire:model="email" placeholder="{{ trans_db('email_placeholder') }}"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-1">{{ trans_db('account_status') }}</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model="status" value="active"
                                        class="form-radio text-blue-600 h-4 w-4 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700 text-sm">{{ trans_db('active') }}</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model="status" value="inactive"
                                        class="form-radio text-red-600 h-4 w-4 border-gray-300 focus:ring-red-500">
                                    <span class="ml-2 text-gray-700 text-sm">{{ trans_db('inactive') }}</span>
                                </label>
                            </div>
                            @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- QR Code (Edit Mode Only) --}}
                        @if($isEditing)
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-blue-800 uppercase tracking-wide mb-1">
                                        {{ trans_db('assigned_qr_code') }}</p>
                                    <code
                                        class="text-sm font-mono text-blue-600 bg-white px-2 py-1 rounded border border-blue-100">{{ $staffMembers->find($staffId)->qr_code }}</code>
                                </div>
                                <button wire:click="generateNewQr({{ $staffId }})"
                                    class="text-sm text-blue-600 hover:text-blue-800 font-semibold underline decoration-blue-300 hover:decoration-blue-600 transition">
                                    {{ trans_db('regenerate') }}
                                </button>
                            </div>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                        <button wire:click.prevent="save" wire:loading.attr="disabled"
                            class="inline-flex justify-center items-center w-full sm:w-auto px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="save">
                                {{ $isEditing ? trans_db('save_changes') : trans_db('create_staff_member') }}
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