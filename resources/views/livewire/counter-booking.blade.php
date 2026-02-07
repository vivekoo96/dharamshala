<div class="min-h-screen bg-gradient-to-br from-slate-100 to-blue-50 p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('counter_booking') }}</h1>
                <p class="text-sm text-gray-600 mt-0.5">{{ trans_db('new_guest_checkin') }}</p>
            </div>
            <button class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition flex items-center gap-2">
                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                <span>{{ trans_db('recent_checkins') }}</span>
            </button>
        </div>

        {{-- Alert System --}}
        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="ml-auto flex-shrink-0 text-green-500 hover:text-green-700">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session()->has('warning'))
            <div class="mb-6 bg-amber-50 border-l-4 border-amber-500 rounded-lg p-4 shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-amber-800">{{ session('warning') }}</p>
                    </div>
                    <button @click="show = false" class="ml-auto flex-shrink-0 text-amber-500 hover:text-amber-700">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Guest Details & Room Selection --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- STEP 1: Guest Details --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-white"></i>
                            </div>
                            <h2 class="text-base font-semibold text-gray-900">{{ trans_db('guest_details') }}</h2>
                        </div>
                        <span class="text-xs font-medium text-blue-600 bg-white px-3 py-1 rounded-full">{{ trans_db('step') }} 1</span>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('mobile_number') }} <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="mobile_number"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="{{ trans_db('enter_mobile') }}">
                                @error('mobile_number') <span class="text-red-600 text-[10px]">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('first_name') }} <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="first_name"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="{{ trans_db('enter_name') }}">
                                @error('first_name') <span class="text-red-600 text-[10px]">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('id_type') }}</label>
                                <select wire:model="id_type"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="aadhaar">{{ trans_db('aadhaar_card') }}</option>
                                    <option value="passport">{{ trans_db('passport') }}</option>
                                    <option value="driving_license">{{ trans_db('driving_license') }}</option>
                                    <option value="voter_id">{{ trans_db('voter_id') }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('id_number') }}</label>
                                <input type="text" wire:model="id_number"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="XXXX-XXXX-XXXX">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('address') }}</label>
                                <input type="text" wire:model="address"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="{{ trans_db('enter_address') }}">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('id_proof_scan') }}</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition bg-gray-50 relative">
                                    <input type="file" wire:model="id_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" id="id_upload">
                                    <div wire:loading wire:target="id_image" class="absolute inset-0 bg-white bg-opacity-80 flex items-center justify-center rounded-lg z-10">
                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                                    </div>
                                    <div class="space-y-1">
                                        <i data-lucide="file-up" class="mx-auto h-8 w-8 text-gray-400"></i>
                                        <p class="text-xs text-gray-600">{{ trans_db('drag_drop_browse') }}</p>
                                        @if($id_image)
                                            <p class="text-[10px] text-green-600 font-bold uppercase">{{ trans_db('file_ready') }}</p>
                                        @else
                                            <p class="text-[10px] text-gray-400 uppercase">{{ trans_db('no_file_selected') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('total_guests') }}</label>
                                <div class="flex items-center space-x-3">
                                    <button type="button" wire:click="$set('number_of_guests', {{ max(1, $number_of_guests - 1) }})"
                                        class="w-10 h-10 bg-gray-100 rounded-xl hover:bg-gray-200 transition flex items-center justify-center">
                                        <i data-lucide="minus" class="w-4 h-4 text-gray-600"></i>
                                    </button>
                                    <input type="number" wire:model="number_of_guests" min="1"
                                        class="w-16 px-3 py-2.5 text-sm text-center border-none bg-slate-50 rounded-xl focus:ring-2 focus:ring-blue-500 font-bold">
                                    <button type="button" wire:click="$set('number_of_guests', {{ $number_of_guests + 1 }})"
                                        class="w-10 h-10 bg-gray-100 rounded-xl hover:bg-gray-200 transition flex items-center justify-center">
                                        <i data-lucide="plus" class="w-4 h-4 text-gray-600"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Select Room --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i data-lucide="home" class="w-5 h-5 text-white"></i>
                            </div>
                            <h2 class="text-base font-semibold text-gray-900">{{ trans_db('select_room') }}</h2>
                        </div>
                        <span class="text-xs font-medium text-blue-600 bg-white px-3 py-1 rounded-full">{{ trans_db('step') }} 2</span>
                    </div>

                    <div class="p-6">
                        {{-- Room Category Filters --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            <button wire:click="setFilter(null)" 
                                class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-xl transition-all {{ is_null($filter_category_id) ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                {{ trans_db('all_rooms') }}
                            </button>
                            @foreach($room_categories as $cat)
                                <button wire:click="setFilter({{ $cat->id }})" 
                                    class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-xl transition-all {{ $filter_category_id == $cat->id ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                    {{ trans_db($cat->name) }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Room Grid --}}
                        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-3">
                            @forelse($available_rooms as $room)
                                @php
                                    $isSelected = in_array($room->id, $selected_rooms);
                                    $statusColors = [
                                        'available' => $isSelected ? 'bg-blue-600 text-white border-blue-700 shadow-xl shadow-blue-100 scale-105' : 'bg-white text-slate-700 border-slate-200 hover:border-blue-400 hover:shadow-md',
                                        'occupied' => 'bg-red-50 text-red-700 border-red-300 border-dashed opacity-50 cursor-not-allowed',
                                        'maintenance' => 'bg-amber-50 text-amber-700 border-amber-300 border-dashed opacity-50 cursor-not-allowed',
                                    ];
                                @endphp
                                
                                <button type="button" 
                                    wire:click="toggleRoom({{ $room->id }})"
                                    @if($room->status !== 'available') disabled @endif
                                    class="relative border-2 rounded-2xl p-3 transition-all duration-300 {{ $statusColors[$room->status] }}">
                                    @if($isSelected)
                                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center">
                                            <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <p class="text-sm font-black">{{ $room->room_number }}</p>
                                        <p class="text-[10px] font-bold opacity-60">₹{{ number_format($room->roomCategory->base_tariff, 0) }}</p>
                                    </div>
                                </button>
                            @empty
                                <div class="col-span-full text-center py-12 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                                    <p class="text-sm text-slate-500 font-medium">{{ trans_db('no_available_rooms_category') }}</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Legend --}}
                        <div class="flex flex-wrap gap-6 mt-8 pt-6 border-t border-slate-100">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-white border-2 border-slate-200 rounded"></div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('available') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-600 rounded"></div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('selected') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-red-100 border border-red-300 rounded"></div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('occupied') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Billing & Payment --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden sticky top-4">
                    <div class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-5 h-5 text-white"></i>
                            </div>
                            <h2 class="text-base font-semibold text-gray-900">{{ trans_db('billing_payment') }}</h2>
                        </div>
                        <span class="text-xs font-medium text-blue-600 bg-white px-3 py-1 rounded-full">{{ trans_db('step') }} 3</span>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Payment Mode --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">{{ trans_db('payment_mode') }}</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach(['cash' => 'banknote', 'upi' => 'smartphone', 'card' => 'credit-card'] as $mode => $icon)
                                    <button type="button" 
                                        wire:click="$set('payment_mode', '{{ $mode }}')"
                                        class="px-2 py-4 rounded-2xl transition-all duration-300 flex flex-col items-center border-2 {{ $payment_mode == $mode ? 'bg-blue-600 text-white border-blue-700 shadow-xl shadow-blue-100 scale-105' : 'bg-slate-50 text-slate-600 border-transparent hover:bg-slate-100' }}">
                                        <i data-lucide="{{ $icon }}" class="w-6 h-6 mb-1"></i>
                                        <span class="text-[10px] font-black uppercase tracking-widest">{{ trans_db($mode) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Booking Summary --}}
                        <div class="bg-slate-50 rounded-[2rem] p-6 space-y-4 border border-slate-100">
                            <div class="flex justify-between items-center text-sm font-bold border-b border-slate-200 pb-4">
                                <span class="text-slate-500">{{ trans_db('rooms_selected') }}</span>
                                <span class="text-slate-900">{{ count($selected_rooms) }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs font-bold">
                                    <span class="text-slate-500">{{ trans_db('total_tariff') }}</span>
                                    <span class="text-slate-900">₹{{ number_format($this->totalTariff, 0) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs font-bold">
                                    <span class="text-slate-500">{{ trans_db('security_deposit') }}</span>
                                    <span class="text-slate-900">₹{{ number_format($this->totalDeposit, 0) }}</span>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-slate-200 flex flex-col">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ trans_db('total_payable') }}</span>
                                <span class="text-4xl font-black text-blue-600">₹{{ number_format($this->totalPayable, 0) }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-3 pt-4">
                            <button type="button" wire:click="resetForm"
                                class="w-full py-4 text-xs font-black uppercase tracking-widest text-slate-500 bg-white border-2 border-slate-200 rounded-2xl hover:bg-slate-50 transition-all">
                                {{ trans_db('reset_form') }}
                            </button>
                            <button type="button" wire:click="createBooking"
                                @if(count($selected_rooms) == 0) disabled @endif
                                class="w-full py-5 text-sm font-black uppercase tracking-widest text-white bg-blue-600 rounded-2xl hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-blue-100 transition-all active:scale-95 flex items-center justify-center space-x-2">
                                <i data-lucide="printer" class="w-5 h-5"></i>
                                <span>{{ trans_db('generate_invoice') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>