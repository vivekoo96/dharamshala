<div>
    {{-- Success Modal --}}
    @if($booking_confirmed)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            wire:click="resetForm">
            <div class="bg-white rounded-2xl p-6 md:p-8 max-w-md w-full shadow-2xl transform animate-bounce-in"
                x-on:click.stop>
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i data-lucide="check" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ trans_db('booking_confirmed') }}</h3>
                    <p class="text-slate-600 mb-6 text-sm">{{ trans_db('thank_you_booking', ['name' => $first_name]) }}</p>
                    <button wire:click="resetForm"
                        class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                        {{ trans_db('book_another_room') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Top Sticky Progress Bar --}}
    <div x-data="{ currentStep: 1 }" x-on:scroll.window="
            if (window.scrollY < 400) currentStep = 1;
            else if (window.scrollY < 1200) currentStep = 2;
            else currentStep = 3;
         "
        class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-md border-b border-slate-200 z-[100] transition-all duration-300 transform shadow-sm"
        :class="window.scrollY > 200 ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all"
                        :class="currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-400'">
                        1</div>
                    <span class="text-sm font-semibold hidden md:block"
                        :class="currentStep == 1 ? 'text-blue-600' : 'text-slate-400'">Guest Info</span>
                </div>
                <div class="h-px w-12 bg-slate-200"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all"
                        :class="currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-400'">
                        2</div>
                    <span class="text-sm font-semibold hidden md:block"
                        :class="currentStep == 2 ? 'text-blue-600' : 'text-slate-400'">Rooms</span>
                </div>
                <div class="h-px w-12 bg-slate-200"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all"
                        :class="currentStep >= 3 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-400'">
                        3</div>
                    <span class="text-sm font-semibold hidden md:block"
                        :class="currentStep == 3 ? 'text-blue-600' : 'text-slate-400'">Payment</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p class="text-xs text-slate-500">Total</p>
                    <p class="text-lg font-bold text-blue-600">₹{{ number_format($total_amount, 0) }}</p>
                </div>
            </div>
        </div>
    </div>


    {{-- Page Header --}}
    <div class="relative py-20 md:py-28" style="background: linear-gradient(135deg, #2563eb 0%, #4338ca 100%);">
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                {{ trans_db('book_now') }}
            </h1>
            <p class="text-blue-50 md:text-lg max-w-2xl mx-auto font-medium">
                Complete your booking in three simple steps
            </p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-[95%] mx-auto px-4 py-12 -mt-10 relative z-20 space-y-8 pb-24">

        {{-- STEP 1: Guest Details --}}
        <section id="step-1" class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            {{-- Header --}}
            <div class="px-6 md:px-8 py-6" style="background: linear-gradient(to right, #2563eb, #1d4ed8);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i data-lucide="user" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ trans_db('guest_details') }}</h2>
                            <p class="text-sm text-blue-100 font-medium">Step 1 of 3</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Content --}}
            <div class="p-6 md:p-10">
                {{-- Personal Information --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-900 mb-5 pb-2 border-b-2 border-blue-100">
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Mobile Number --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                {{ trans_db('mobile_number') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" wire:model="mobile_number" placeholder="10-digit mobile"
                                class="w-full px-4 py-3 text-slate-900 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                            @error('mobile_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Guest Name --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                {{ trans_db('guest_name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="first_name" placeholder="Full name"
                                class="w-full px-4 py-3 text-slate-900 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ID Type --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                {{ trans_db('id_type') }}
                            </label>
                            <select wire:model="id_type"
                                class="w-full px-4 py-3 text-slate-900 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                                <option>Aadhar Card</option>
                                <option>Passport</option>
                                <option>Driving License</option>
                                <option>Voter ID</option>
                            </select>
                        </div>

                        {{-- ID Number --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                {{ trans_db('id_number') }}
                            </label>
                            <input type="text" wire:model="id_number" placeholder="ID number"
                                class="w-full px-4 py-3 text-slate-900 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                        </div>
                    </div>
                </div>

                {{-- Stay Details --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-900 mb-5 pb-2 border-b-2 border-blue-100">
                        Stay Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Check-in --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                {{ trans_db('checkin_date') }}
                            </label>
                            <input type="datetime-local" wire:model.live="check_in"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="w-full px-4 py-3 text-slate-900 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                        </div>

                        {{-- Check-out --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                {{ trans_db('checkout_date') }}
                            </label>
                            <input type="datetime-local" wire:model.live="check_out" min="{{ $check_in }}"
                                class="w-full px-4 py-3 text-slate-900 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                        </div>
                    </div>
                </div>

                {{-- Guest Count --}}
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-5 pb-2 border-b-2 border-blue-100">
                        {{ trans_db('guests_count') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach(['adults_male' => 'Male', 'adults_female' => 'Female', 'children' => 'Child'] as $key => $label)
                            <div class="bg-slate-50 border-2 border-slate-200 rounded-xl p-5">
                                <p class="text-sm font-semibold text-slate-700 mb-3 text-center">{{ $label }}</p>
                                <div class="flex items-center justify-between gap-3">
                                    <button type="button" wire:click="$set('{{ $key }}', {{ max(0, $$key - 1) }})"
                                        class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-300 text-slate-600 rounded-lg hover:border-red-500 hover:text-red-500 transition-all">
                                        <i data-lucide="minus" class="w-5 h-5"></i>
                                    </button>
                                    <span
                                        class="text-2xl font-bold text-slate-900 min-w-[3rem] text-center">{{ $$key }}</span>
                                    <button type="button" wire:click="$set('{{ $key }}', {{ $$key + 1 }})"
                                        class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                                        <i data-lucide="plus" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Continue Button --}}
                <div class="mt-8 flex justify-end">
                    <button onclick="document.getElementById('step-2').scrollIntoView({behavior: 'smooth'})"
                        class="flex items-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-lg">
                        Continue to Rooms
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </section>

        {{-- STEP 2: Room Selection --}}
        <section id="step-2" class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            {{-- Header --}}
            <div class="px-6 md:px-8 py-6" style="background: linear-gradient(to right, #059669, #0d9488);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i data-lucide="bed" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ trans_db('select_room') }}</h2>
                            <p class="text-sm text-emerald-100">Step 2 of 3</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Capacity Gauge --}}
            @php $totalAdults = $adults_male + $adults_female; @endphp
            @if($totalAdults > 0)
                <div class="bg-blue-50 px-6 md:px-8 py-4 border-b border-blue-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Accommodation Status</p>
                            <p class="text-xs text-slate-600">
                                @if($this->selected_capacity < $totalAdults)
                                    <span class="text-orange-600 font-bold">Need {{ $totalAdults - $this->selected_capacity }}
                                        more spots</span>
                                @else
                                    <span class="text-emerald-600 font-bold">All {{ $totalAdults }} adults accommodated ✓</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex-1 md:max-w-md">
                            <div class="h-3 w-full bg-white rounded-full border border-slate-200 overflow-hidden">
                                <div class="h-full transition-all duration-700 {{ $this->selected_capacity >= $totalAdults ? 'bg-emerald-500' : 'bg-blue-600' }}"
                                    style="width: {{ min(100, ($this->selected_capacity / max($totalAdults, 1)) * 100) }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Room Content --}}
            <div class="p-6 md:p-10">
                {{-- Building Selector --}}
                @if($buildings->count() > 1)
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Select Building</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($buildings as $building)
                                <button wire:click="selectBuilding({{ $building->id }})"
                                    class="px-5 py-2.5 rounded-xl font-semibold transition-all {{ $selectedBuildingId == $building->id ? 'bg-emerald-600 text-white shadow-lg' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                                    {{ $building->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Room Cards --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @forelse($rooms as $room)
                                    <div wire:click="toggleRoom({{ $room->id }})" class="relative cursor-pointer group transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl rounded-2xl border px-4 py-3 flex items-center justify-between overflow-hidden
                                                                                                            {{ in_array($room->id, $selected_rooms)
                        ? 'border-transparent text-white shadow-lg ring-2 ring-blue-200 scale-[1.02]'
                        : 'bg-white border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 hover:shadow-indigo-100 hover:shadow-lg hover:-translate-y-1'
                                                            }}"
                                        style="{{ in_array($room->id, $selected_rooms) ? 'background: linear-gradient(to right, #2563eb, #4f46e5);' : '' }}">

                                        {{-- Loading Spinner Overlay --}}
                                        <div wire:loading wire:target="toggleRoom({{ $room->id }})"
                                            class="absolute inset-0 z-50 bg-white/60 backdrop-blur-[1px] flex items-center justify-center rounded-2xl">
                                            <i data-lucide="loader-2" class="w-6 h-6 text-blue-600 animate-spin"></i>
                                        </div>

                                        {{-- Selection Glow Effect --}}
                                        @if(in_array($room->id, $selected_rooms))
                                            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity">
                                            </div>
                                        @endif

                                        {{-- Left: Room Info --}}
                                        <div class="flex items-center gap-3">
                                            {{-- Check Icon (Visible when selected) --}}
                                            <div
                                                class="flex-shrink-0 transition-all duration-300 {{ in_array($room->id, $selected_rooms) ? 'w-5 opacity-100 translate-x-0' : 'w-0 opacity-0 -translate-x-2' }}">
                                                <i data-lucide="check-circle-2" class="w-5 h-5 text-white"></i>
                                            </div>

                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="font-bold text-lg leading-none {{ in_array($room->id, $selected_rooms) ? 'text-white' : 'text-slate-800 group-hover:text-blue-600' }}">
                                                        {{ $room->room_number }}
                                                    </span>
                                                </div>
                                                <p
                                                    class="text-[10px] uppercase font-bold tracking-wider mt-0.5 {{ in_array($room->id, $selected_rooms) ? 'text-blue-100' : 'text-slate-400' }}">
                                                    {{ $room->roomCategory->name ?? 'Room' }}
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Right: Price --}}
                                        <div class="text-right">
                                            <p
                                                class="text-sm font-black leading-none {{ in_array($room->id, $selected_rooms) ? 'text-white' : 'text-slate-900' }}">
                                                ₹{{ number_format($room->roomCategory->base_tariff ?? 0, 0) }}
                                            </p>
                                            @if(in_array($room->id, $selected_rooms))
                                                <p class="text-[10px] text-blue-100 font-medium">Selected</p>
                                            @else
                                                <div class="flex items-center gap-1 justify-end text-slate-400 mt-0.5">
                                                    <i data-lucide="users" class="w-3 h-3"></i>
                                                    <span class="text-[10px] font-bold">{{ $room->roomCategory->capacity ?? 2 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                    @empty
                        <div
                            class="col-span-full py-12 text-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50">
                            <div
                                class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white shadow-sm mb-3">
                                <i data-lucide="hotel" class="w-6 h-6 text-slate-400"></i>
                            </div>
                            <p class="text-slate-500 font-medium">No rooms available in this building</p>
                        </div>
                    @endforelse
                </div>

                {{-- Continue Button --}}
                <div class="mt-8 flex justify-between">
                    <button onclick="document.getElementById('step-1').scrollIntoView({behavior: 'smooth'})"
                        class="flex items-center gap-2 text-slate-600 px-6 py-3 rounded-xl font-semibold hover:bg-slate-100 transition-all">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        Back
                    </button>
                    <button onclick="document.getElementById('step-3').scrollIntoView({behavior: 'smooth'})"
                        class="flex items-center gap-2 bg-emerald-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-emerald-700 transition-all shadow-lg">
                        Continue to Payment
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </section>

        {{-- STEP 3: Billing & Payment --}}
        <section id="step-3" class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            {{-- Header --}}
            <div class="px-6 md:px-8 py-6" style="background: linear-gradient(to right, #4f46e5, #7c3aed);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i data-lucide="credit-card" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ trans_db('billing_payment') }}</h2>
                            <p class="text-sm text-indigo-100 font-medium">Step 3 of 3</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Content --}}
            <div class="p-6 md:p-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Payment Method --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-5 pb-2 border-b-2 border-indigo-100">
                            {{ trans_db('choose_payment_method') }}
                        </h3>
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            @foreach(['cash' => 'banknote', 'upi' => 'smartphone', 'card' => 'credit-card'] as $mode => $icon)
                                <button wire:click="setPaymentMode('{{ $mode }}')"
                                    class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 transition-all {{ $payment_mode === $mode ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg' : 'bg-white border-slate-200 hover:border-indigo-300' }}">
                                    <i data-lucide="{{ $icon }}" class="w-8 h-8"></i>
                                    <span class="text-sm font-semibold capitalize">{{ trans_db($mode) }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                            <div class="flex items-start gap-3">
                                <i data-lucide="shield-check" class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-1">Secure Payment</h4>
                                    <p class="text-sm text-slate-600">Your payment details are encrypted and secure.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Summary --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-5 pb-2 border-b-2 border-indigo-100">
                            Booking Summary
                        </h3>
                        <div class="rounded-xl p-6 text-white"
                            style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                            <div class="mb-6">
                                <h4 class="text-2xl font-bold mb-2">Stay Summary</h4>
                                <div class="flex gap-2">
                                    <span class="text-xs bg-white/20 px-3 py-1 rounded-full font-semibold">{{ $nights }}
                                        NIGHTS</span>
                                    <span
                                        class="text-xs bg-white/20 px-3 py-1 rounded-full font-semibold">{{ count($selected_rooms) }}
                                        ROOMS</span>
                                </div>
                            </div>

                            <div class="space-y-3 mb-6 pb-6 border-b border-white/20">
                                <div class="flex justify-between">
                                    <span class="text-indigo-100">Base Stay ({{ $nights }} Nights)</span>
                                    <span class="font-bold">₹{{ number_format($total_amount - $deposit, 0) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-indigo-100">Refundable Deposit</span>
                                    <span class="font-bold">₹{{ number_format($deposit, 0) }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <p class="text-indigo-200 text-sm mb-1">TOTAL PAYABLE</p>
                                    <p class="text-4xl font-bold">₹{{ number_format($total_amount, 0) }}</p>
                                </div>
                            </div>

                            @if($this->selected_capacity >= ($adults_male + $adults_female))
                                <button wire:click="confirmBooking" wire:loading.attr="disabled"
                                    class="w-full py-4 bg-white text-indigo-700 rounded-xl font-bold hover:bg-indigo-50 transition-all shadow-lg flex items-center justify-center gap-2">
                                    <span wire:loading.remove>{{ trans_db('confirm_booking') }}</span>
                                    <div wire:loading
                                        class="w-5 h-5 border-2 border-indigo-600/30 border-t-indigo-600 rounded-full animate-spin">
                                    </div>
                                    <i data-lucide="check-circle" class="w-5 h-5" wire:loading.remove></i>
                                </button>
                            @else
                                <div class="bg-orange-500/20 border border-orange-300 rounded-xl p-4 text-center">
                                    <p class="text-sm font-semibold">Please select enough rooms to accommodate all guests
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Back Button --}}
                <div class="mt-8">
                    <button onclick="document.getElementById('step-2').scrollIntoView({behavior: 'smooth'})"
                        class="flex items-center gap-2 text-slate-600 px-6 py-3 rounded-xl font-semibold hover:bg-slate-100 transition-all">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        Back to Rooms
                    </button>
                </div>
            </div>
        </section>

    </div>
</div>