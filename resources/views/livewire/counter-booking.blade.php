<div class="min-h-screen bg-gradient-to-br from-slate-100 to-blue-50 p-4 md:p-8">
    <div class="max-w-[99.5%] mx-auto">
        {{-- Header --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('counter_booking') }}</h1>
                <p class="text-sm text-gray-600 mt-0.5">{{ trans_db('new_guest_checkin') }}</p>
            </div>
            <button
                class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition flex items-center gap-2">
                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                <span>{{ trans_db('recent_checkins') }}</span>
            </button>
        </div>

        {{-- Alert System --}}
        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm" x-data="{ show: true }"
                x-show="show" x-transition>
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
            <div class="mb-6 bg-amber-50 border-l-4 border-amber-500 rounded-lg p-4 shadow-sm" x-data="{ show: true }"
                x-show="show" x-transition>
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
                        <span
                            class="text-xs font-medium text-blue-600 bg-white px-3 py-1 rounded-full">{{ trans_db('step') }}
                            1</span>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('mobile_number') }}
                                    <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="mobile_number"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="{{ trans_db('enter_mobile') }}">
                                @error('mobile_number') <span class="text-red-600 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('first_name') }}
                                    <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="first_name"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="{{ trans_db('enter_name') }}">
                                @error('first_name') <span class="text-red-600 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('id_type') }}</label>
                                <select wire:model="id_type"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="aadhaar">{{ trans_db('aadhaar_card') }}</option>
                                    <option value="passport">{{ trans_db('passport') }}</option>
                                    <option value="driving_license">{{ trans_db('driving_license') }}</option>
                                    <option value="voter_id">{{ trans_db('voter_id') }}</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('id_number') }}</label>
                                <input type="text" wire:model="id_number"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="XXXX-XXXX-XXXX">
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('address') }}</label>
                                <input type="text" wire:model="address"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="{{ trans_db('enter_address') }}">
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">{{ trans_db('id_proof_scan') }}</label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition bg-gray-50 relative">
                                    <input type="file" wire:model="id_image" accept="image/*"
                                        class="absolute inset-0 opacity-0 cursor-pointer" id="id_upload">
                                    <div wire:loading wire:target="id_image"
                                        class="absolute inset-0 bg-white bg-opacity-80 flex items-center justify-center rounded-lg z-10">
                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                                    </div>
                                    <div class="space-y-1">
                                        <i data-lucide="file-up" class="mx-auto h-8 w-8 text-gray-400"></i>
                                        <p class="text-xs text-gray-600">{{ trans_db('drag_drop_browse') }}</p>
                                        @if($id_image)
                                            <p class="text-[10px] text-green-600 font-bold uppercase">
                                                {{ trans_db('file_ready') }}
                                            </p>
                                        @else
                                            <p class="text-[10px] text-gray-400 uppercase">
                                                {{ trans_db('no_file_selected') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-2 grid grid-cols-3 gap-4">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 mb-2 block uppercase tracking-[0.2em]">Adult (M)</label>
                                    <div class="flex items-center justify-between bg-slate-50 p-1 rounded-xl border border-slate-200">
                                        <button type="button" wire:click="$set('adults_male', {{ max(0, $adults_male - 1) }})" class="w-8 h-8 flex items-center justify-center bg-white text-slate-500 rounded-lg shadow-sm hover:bg-slate-100 transition-all active:scale-95">
                                            <i data-lucide="minus" class="w-3 h-3"></i>
                                        </button>
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-black text-slate-900 leading-none">{{ $adults_male }}</span>
                                            <span class="text-[7px] font-bold text-slate-400 uppercase tracking-tighter">Male</span>
                                        </div>
                                        <button type="button" wire:click="$set('adults_male', {{ $adults_male + 1 }})" class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                                            <i data-lucide="plus" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 mb-2 block uppercase tracking-[0.2em]">Adult (F)</label>
                                    <div class="flex items-center justify-between bg-slate-50 p-1 rounded-xl border border-slate-200">
                                        <button type="button" wire:click="$set('adults_female', {{ max(0, $adults_female - 1) }})" class="w-8 h-8 flex items-center justify-center bg-white text-slate-500 rounded-lg shadow-sm hover:bg-slate-100 transition-all active:scale-95">
                                            <i data-lucide="minus" class="w-3 h-3"></i>
                                        </button>
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-black text-slate-900 leading-none">{{ $adults_female }}</span>
                                            <span class="text-[7px] font-bold text-slate-400 uppercase tracking-tighter">Female</span>
                                        </div>
                                        <button type="button" wire:click="$set('adults_female', {{ $adults_female + 1 }})" class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                                            <i data-lucide="plus" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 mb-2 block uppercase tracking-[0.2em]">Children</label>
                                    <div class="flex items-center justify-between bg-slate-50 p-1 rounded-xl border border-slate-200">
                                        <button type="button" wire:click="$set('children', {{ max(0, $children - 1) }})" class="w-8 h-8 flex items-center justify-center bg-white text-slate-500 rounded-lg shadow-sm hover:bg-slate-100 transition-all active:scale-95">
                                            <i data-lucide="minus" class="w-3 h-3"></i>
                                        </button>
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-black text-slate-900 leading-none">{{ $children }}</span>
                                            <span class="text-[7px] font-bold text-slate-400 uppercase tracking-tighter">Child</span>
                                        </div>
                                        <button type="button" wire:click="$set('children', {{ $children + 1 }})" class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                                            <i data-lucide="plus" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Select Room --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="home" class="w-5 h-5 text-white"></i>
                                </div>
                                <h2 class="text-base font-semibold text-gray-900">{{ trans_db('select_room') }}</h2>
                            </div>
                            @if(($adults_male + $adults_female) > 0)
                                <div class="h-6 w-px bg-blue-200"></div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-black {{ $this->selectedCapacity >= ($adults_male + $adults_female) ? 'text-emerald-600' : 'text-orange-500' }} uppercase tracking-widest">
                                        Accommodated: {{ $this->selectedCapacity }}/{{ $adults_male + $adults_female }} Group
                                    </span>
                                </div>
                            @endif
                        </div>
                        <span
                            class="text-xs font-medium text-blue-600 bg-white px-3 py-1 rounded-full">{{ trans_db('step') }}
                            2</span>
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
                        <div class="space-y-10">
                            @foreach($buildings as $building)
                                <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-100">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                            <i data-lucide="building-2" class="w-5 h-5 text-blue-600"></i>
                                            {{ $building->name }}
                                        </h3>
                                        <div class="flex gap-4">
                                            <div class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                <div class="w-3 h-3 rounded bg-white border-2 border-emerald-500"></div>
                                                Available / Sharing
                                            </div>
                                            <div class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                <div class="w-3 h-3 rounded bg-emerald-700"></div>
                                                Selected
                                            </div>
                                            <div class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                <div class="w-3 h-3 rounded bg-slate-200 border border-slate-300"></div>
                                                Room full
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-10">
                                        @foreach($building->floors->sortByDesc('floor_number') as $floor)
                                            <div class="space-y-4">
                                                {{-- Floor Banner --}}
                                                <div class="flex items-center gap-4 px-4">
                                                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] whitespace-nowrap">
                                                        @if($floor->floor_number == 0) Ground Floor @else {{ $floor->floor_number }}{{ in_array($floor->floor_number, [1,2,3]) ? ['st','nd','rd'][$floor->floor_number-1] : 'th' }} Floor @endif
                                                    </span>
                                                    <div class="h-px bg-slate-200 flex-1 rounded-full"></div>
                                                </div>

                                                <div class="flex flex-wrap gap-2 px-4">
                                                    @foreach($floor->rooms as $room)
                                                        @php
                                                            $isSelected = in_array($room->id, $selected_rooms);
                                                            $isRoomFull = $room->remaining_beds <= 0;
                                                            $canSelect = $room->remaining_beds >= ($adults_male + $adults_female);
                                                            
                                                            $categoryType = strtolower($room->roomCategory->name);
                                                            $isAC = str_contains($categoryType, 'ac') && !str_contains($categoryType, 'non');

                                                            if ($isSelected) {
                                                                $uiClass = 'bg-emerald-700 border-emerald-800 shadow-emerald-200 text-white';
                                                            } elseif ($canSelect) {
                                                                $uiClass = 'bg-white border-emerald-500 hover:bg-emerald-50 text-emerald-800';
                                                            } else {
                                                                $uiClass = 'bg-slate-200 border-slate-300 text-slate-400 opacity-60';
                                                            }
                                                        @endphp
                                                        
                                                        <button 
                                                            wire:key="cnt-room-{{ $room->id }}"
                                                            type="button" 
                                                            @if($canSelect || $isSelected) wire:click="toggleRoom({{ $room->id }})" @endif
                                                            @if(!$canSelect && !$isSelected) disabled @endif
                                                            class="w-14 h-16 rounded-lg border-2 transition-all relative flex flex-col items-center justify-between p-1 {{ $uiClass }} {{ $canSelect || $isSelected ? 'cursor-pointer hover:-translate-y-1' : 'cursor-not-allowed opacity-40' }}">
                                                            
                                                            <div class="text-[6px] font-black uppercase tracking-tighter opacity-70">
                                                                {{ $isAC ? 'AC' : 'NON-AC' }}
                                                            </div>

                                                            <div class="text-xs font-black leading-none">
                                                                {{ $room->room_number }}
                                                            </div>

                                                            <div class="flex flex-col items-center gap-0.5">
                                                                <div class="text-[7px] font-bold opacity-80 leading-none">
                                                                    {{ $room->occupied_beds_count }}/{{ $room->roomCategory->capacity }}
                                                                </div>
                                                                <div class="w-6 h-0.5 bg-black/10 rounded-full overflow-hidden">
                                                                    <div class="h-full {{ $isSelected ? 'bg-white' : 'bg-emerald-500' }}" style="width: {{ ($room->occupied_beds_count / $room->roomCategory->capacity) * 100 }}%"></div>
                                                                </div>
                                                            </div>

                                                            @if($isSelected)
                                                                <div class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-white text-emerald-700 rounded-full flex items-center justify-center shadow-lg border border-emerald-700">
                                                                    <i data-lucide="check" class="w-2.5 h-2.5"></i>
                                                                </div>
                                                            @endif
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
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
                        <span
                            class="text-xs font-medium text-blue-600 bg-white px-3 py-1 rounded-full">{{ trans_db('step') }}
                            3</span>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Payment Mode --}}
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">{{ trans_db('payment_mode') }}</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach(['cash' => 'banknote', 'upi' => 'smartphone', 'card' => 'credit-card'] as $mode => $icon)
                                    <button type="button" wire:click="$set('payment_mode', '{{ $mode }}')"
                                        class="px-2 py-4 rounded-2xl transition-all duration-300 flex flex-col items-center border-2 {{ $payment_mode == $mode ? 'bg-blue-600 text-white border-blue-700 shadow-xl shadow-blue-100 scale-105' : 'bg-slate-50 text-slate-600 border-transparent hover:bg-slate-100' }}">
                                        <i data-lucide="{{ $icon }}" class="w-6 h-6 mb-1"></i>
                                        <span
                                            class="text-[10px] font-black uppercase tracking-widest">{{ trans_db($mode) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Discount --}}
                        <div class="bg-blue-50/50 p-4 rounded-3xl border border-blue-100/50 space-y-3">
                            <label class="block text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] px-2">Apply Discount</label>
                            <div class="space-y-2">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-blue-600 font-bold sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" wire:model.live="discount" 
                                        class="block w-full pl-8 pr-4 py-2 bg-white border border-blue-100 rounded-2xl focus:ring-blue-500 focus:border-blue-500 font-bold text-slate-700 sm:text-sm" placeholder="Discount Amount">
                                </div>
                                @if($discount > 0)
                                    <input type="text" wire:model.live="discount_reason" 
                                        class="block w-full px-4 py-2 bg-white border border-blue-100 rounded-2xl focus:ring-blue-500 focus:border-blue-500 font-medium text-slate-600 sm:text-sm" placeholder="Reason (Optional)">
                                @endif
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
                                @if($discount > 0)
                                    <div class="flex justify-between items-center text-xs font-bold text-emerald-600">
                                        <span>Discount Applied</span>
                                        <span>- ₹{{ number_format($discount, 0) }}</span>
                                    </div>
                                @endif
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
                            @if($this->selectedCapacity >= ($adults_male + $adults_female))
                                <button type="button" wire:click="createBooking" @if(count($selected_rooms) == 0) disabled @endif
                                    class="w-full py-5 text-sm font-black uppercase tracking-widest text-white bg-blue-600 rounded-2xl hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-blue-100 transition-all active:scale-95 flex items-center justify-center space-x-2">
                                    <i data-lucide="printer" class="w-5 h-5"></i>
                                    <span>{{ trans_db('generate_invoice') }}</span>
                                </button>
                            @else
                                <div class="w-full py-4 bg-slate-50 text-slate-400 rounded-2xl font-bold border border-slate-100 flex flex-col items-center justify-center gap-1 text-[10px] uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="alert-circle" class="w-3 h-3 text-orange-500"></i>
                                        <span>Capacity Insufficient</span>
                                    </div>
                                    <span class="text-[8px] opacity-70">Please select rooms for {{ ($adults_male + $adults_female) - $this->selectedCapacity }} more adults</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>