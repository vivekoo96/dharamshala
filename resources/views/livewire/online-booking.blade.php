<div>
    {{-- Success Modal --}}
    @if($booking_confirmed)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click="resetForm">
            <div class="bg-white rounded-2xl p-6 md:p-8 max-w-md w-full shadow-2xl transform animate-bounce-in" x-on:click.stop>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i data-lucide="check" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ trans_db('booking_confirmed') }}</h3>
                    <p class="text-slate-600 mb-6 text-sm">{{ trans_db('thank_you_booking', ['name' => $first_name]) }}</p>
                    <button wire:click="resetForm" class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                        {{ trans_db('book_another_room') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="relative bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-800 py-20 overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl"></div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">{{ trans_db('book_now') }}</h1>
            <p class="text-blue-50 md:text-lg font-medium max-w-2xl mx-auto leading-relaxed opacity-90">
                Experience a peaceful and spiritual stay at our heritage dharamshala. Complete the steps below to confirm your visit.
            </p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container mx-auto px-4 py-8 -mt-12 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Left Panel - Forms (5/12) --}}
            <div class="lg:col-span-5 space-y-6">
                {{-- Guest Details Card --}}
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-100 px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-slate-500"></i>
                            <h2 class="text-base font-bold text-slate-800">{{ trans_db('guest_details') }}</h2>
                        </div>
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Step 1</span>
                    </div>
                    
                    <div class="p-5 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-slate-600 mb-1.5 block uppercase tracking-tight">{{ trans_db('mobile_number') }} <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="tel" wire:model="mobile_number" placeholder="10-digit mobile" class="w-full pl-4 pr-10 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition bg-slate-50/50">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                        <i data-lucide="search" class="w-4 h-4"></i>
                                    </span>
                                </div>
                                @error('mobile_number') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600 mb-1.5 block uppercase tracking-tight">{{ trans_db('guest_name') }} <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="first_name" placeholder="Full name" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition bg-slate-50/50">
                                @error('first_name') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-slate-600 mb-1.5 block uppercase tracking-tight">{{ trans_db('id_type') }}</label>
                                <select wire:model="id_type" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition bg-slate-50/50">
                                    <option>Aadhar Card</option>
                                    <option>Passport</option>
                                    <option>Driving License</option>
                                    <option>Voter ID</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600 mb-1.5 block uppercase tracking-tight">{{ trans_db('id_number') }}</label>
                                <input type="text" wire:model="id_number" placeholder="ID Number" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition bg-slate-50/50">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-slate-600 mb-1.5 block uppercase tracking-tight">{{ trans_db('checkin_date') }}</label>
                                <input type="datetime-local" wire:model.live="check_in" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition bg-slate-50/50">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600 mb-1.5 block uppercase tracking-tight">{{ trans_db('checkout_date') }}</label>
                                <input type="datetime-local" wire:model.live="check_out" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition bg-slate-50/50">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-600 mb-1.5 block uppercase tracking-tight">{{ trans_db('total_members') }}</label>
                            <div class="flex items-center gap-4 bg-white p-1 rounded-2xl border border-slate-200 w-fit">
                                <button wire:click="$set('guests', {{ max(1, $guests - 1) }})" class="w-10 h-10 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition text-lg">−</button>
                                <input type="number" wire:model="guests" readonly class="w-10 text-center bg-transparent border-none text-base font-bold text-slate-800">
                                <button wire:click="$set('guests', {{ $guests + 1 }})" class="w-10 h-10 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition text-lg">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Billing & Payment Card --}}
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-100 px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i data-lucide="credit-card" class="w-5 h-5 text-slate-500"></i>
                            <h2 class="text-base font-bold text-slate-800">{{ trans_db('billing_payment') }}</h2>
                        </div>
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Step 3</span>
                    </div>
                    
                    <div class="p-5 space-y-5">
                        <div>
                            <label class="text-xs font-semibold text-slate-600 mb-3 block uppercase tracking-tight">{{ trans_db('payment_mode') }}</label>
                            <div class="grid grid-cols-3 gap-3">
                                <button wire:click="setPaymentMode('cash')" class="flex flex-col items-center gap-2 p-3 rounded-2xl border transition-all {{ $payment_mode === 'cash' ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-slate-50 border-slate-200 hover:border-blue-300 text-slate-600' }}">
                                    <i data-lucide="banknote" class="w-6 h-6"></i>
                                    <span class="text-xs font-bold">Cash</span>
                                </button>
                                <button wire:click="setPaymentMode('upi')" class="flex flex-col items-center gap-2 p-3 rounded-2xl border transition-all {{ $payment_mode === 'upi' ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-slate-50 border-slate-200 hover:border-blue-300 text-slate-600' }}">
                                    <i data-lucide="smartphone" class="w-6 h-6"></i>
                                    <span class="text-xs font-bold">UPI</span>
                                </button>
                                <button wire:click="setPaymentMode('card')" class="flex flex-col items-center gap-2 p-3 rounded-2xl border transition-all {{ $payment_mode === 'card' ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-slate-50 border-slate-200 hover:border-blue-300 text-slate-600' }}">
                                    <i data-lucide="credit-card" class="w-6 h-6"></i>
                                    <span class="text-xs font-bold">Card</span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-blue-50/50 rounded-2xl p-5 border border-blue-100 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">{{ trans_db('security_deposit') }}</span>
                                <span class="font-bold text-slate-900">₹{{ number_format($deposit, 0) }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-blue-100">
                                <span class="font-bold text-slate-900 text-base">{{ trans_db('total_payable_amount') }}</span>
                                <span class="text-3xl font-black text-blue-600">₹{{ number_format($total_amount, 0) }}</span>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button wire:click="resetForm" class="flex-1 py-3.5 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition text-sm">
                                {{ trans_db('reset') }}
                            </button>
                            <button wire:click="confirmBooking" class="flex-1 py-3.5 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-200 transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-blue-100">
                                <i data-lucide="printer" class="w-4 h-4"></i>
                                <span>{{ trans_db('confirm') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Panel - Room Selection (7/12) --}}
            <div class="lg:col-span-7 bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-fit sticky top-24">
                <div class="bg-slate-50 border-b border-slate-100 px-5 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="home" class="w-5 h-5 text-slate-500"></i>
                        <h2 class="text-base font-bold text-slate-800">{{ trans_db('select_room') }}</h2>
                    </div>
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Step 2</span>
                </div>

                <div class="p-6">
                    {{-- Building Filters --}}
                    @if($buildings->count() > 1)
                        <div class="flex gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
                            @foreach($buildings as $building)
                                <button wire:click="selectBuilding({{ $building->id }})" class="px-5 py-2 rounded-xl font-bold text-xs whitespace-nowrap transition-all {{ $selectedBuildingId == $building->id ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                    {{ $building->name }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Rooms Grid --}}
                    @php
                        $currentBuilding = collect($buildings)->firstWhere('id', $selectedBuildingId);
                    @endphp

                    @if($currentBuilding)
                        <div class="space-y-8 max-h-[calc(100vh-320px)] overflow-y-auto pr-3 custom-scrollbar">
                            @foreach($currentBuilding->floors as $floor)
                                <div>
                                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-3">
                                        <span>{{ $floor->floor_number }}</span>
                                        <div class="h-px bg-slate-100 flex-1"></div>
                                    </h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                                        @foreach($floor->rooms as $room)
                                            @php
                                                $isAvailable = $room->status === 'available';
                                                $isTooSmall = $room->roomCategory->capacity < $guests;
                                                $canSelect = $isAvailable && !$isTooSmall;
                                                $isSelected = $selected_room_id == $room->id;
                                                
                                                $categoryType = strtolower($room->roomCategory->name);
                                                if (str_contains($categoryType, 'ac') && !str_contains($categoryType, 'non')) {
                                                    $bgColor = $isSelected ? 'bg-blue-600 border-blue-600' : ($canSelect ? 'bg-white border-blue-100 shadow-sm' : 'bg-slate-50 border-slate-100');
                                                    $accentColor = $isSelected ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600';
                                                    $label = 'AC';
                                                } elseif (str_contains($categoryType, 'non')) {
                                                    $bgColor = $isSelected ? 'bg-blue-600 border-blue-600' : ($canSelect ? 'bg-white border-green-100 shadow-sm' : 'bg-slate-50 border-slate-100');
                                                    $accentColor = $isSelected ? 'bg-white/20 text-white' : 'bg-green-50 text-green-600';
                                                    $label = 'NON-AC';
                                                } else {
                                                    $bgColor = $isSelected ? 'bg-blue-600 border-blue-600' : ($canSelect ? 'bg-white border-yellow-100 shadow-sm' : 'bg-slate-50 border-slate-100');
                                                    $accentColor = $isSelected ? 'bg-white/20 text-white' : 'bg-yellow-50 text-yellow-600';
                                                    $label = 'DORM';
                                                }
                                            @endphp

                                            <button 
                                                @if($canSelect) wire:click="selectRoom({{ $room->roomCategory->id }}, {{ $room->id }})" @endif
                                                class="relative p-3.5 rounded-2xl border transition-all text-left {{ $bgColor }} {{ $canSelect ? 'hover:shadow-xl hover:-translate-y-1 cursor-pointer group' : 'opacity-50 cursor-not-allowed' }}">
                                                
                                                <div class="flex flex-col gap-2">
                                                    <div class="flex justify-between items-center">
                                                        <span class="px-2 py-0.5 rounded-lg text-[8px] font-black uppercase tracking-tighter {{ $accentColor }}">{{ $label }}</span>
                                                        @if($isSelected)
                                                            <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="flex flex-col">
                                                        <span class="text-lg font-black {{ $isSelected ? 'text-white' : 'text-slate-800' }}">#{{ $room->room_number }}</span>
                                                        <span class="text-sm font-black {{ $isSelected ? 'text-white' : 'text-blue-600' }}">₹{{ number_format($room->roomCategory->base_tariff, 0) }}</span>
                                                    </div>

                                                    <div class="text-[9px] font-bold {{ $isSelected ? 'text-white/70' : 'text-slate-400' }} uppercase tracking-widest">
                                                        @if($canSelect)
                                                            Available
                                                        @elseif($isTooSmall)
                                                            Small
                                                        @else
                                                            {{ ucfirst($room->status) }}
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($isSelected)
                                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-white text-blue-600 rounded-full flex items-center justify-center font-black shadow-xl text-xs border border-blue-600">
                                                        <i data-lucide="check" class="w-4 h-4"></i>
                                                    </div>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Legend --}}
                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap gap-6 justify-center">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em]">Occupied</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full border border-blue-200 bg-white"></div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em]">Available</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em]">Selected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce-in {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-bounce-in {
            animation: bounce-in 0.5s ease-out;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</div>
