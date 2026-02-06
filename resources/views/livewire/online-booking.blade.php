<div class="min-h-screen relative">
    {{-- Premium Background Layer --}}
    <div class="fixed inset-0 z-[-10] pointer-events-none overflow-hidden">
        {{-- Soft Base Gradient --}}
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-100/40 via-white to-slate-50"></div>
        
        {{-- Aurora Blobs (Vibrant & Layered) --}}
        <div class="absolute -top-[10%] -left-[10%] w-[70%] h-[70%] bg-blue-400/10 blur-[120px] rounded-full animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-[50%] h-[50%] bg-emerald-400/10 blur-[100px] rounded-full animate-bounce [animation-duration:10s]"></div>
        <div class="absolute bottom-[10%] left-[10%] w-[60%] h-[40%] bg-indigo-400/10 blur-[140px] rounded-full"></div>
        <div class="absolute top-[60%] right-[20%] w-[30%] h-[30%] bg-amber-200/5 blur-[80px] rounded-full"></div>

        {{-- Subtle Dot Grid Texture --}}
        <div class="absolute inset-0 opacity-[0.6]" style="background-image: radial-gradient(#94a3b8 0.5px, transparent 0.5px); background-size: 32px 32px;"></div>
    </div>

    <!-- Online Booking Page -->
    {{-- Single Clean Navigation Bar --}}
    <nav class="bg-white/60 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/50 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- Left: Logo + Branding --}}
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 leading-none">Dharamshala Connect</h1>
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mt-1">Shree Ram Trust</p>
                    </div>
                </div>

                {{-- Right: Navigation + Language Switcher --}}
                <div class="flex items-center space-x-8">
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="/" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">{{ trans_db('home') }}</a>
                        <a href="/book" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">{{ trans_db('book_now') }}</a>
                        <a href="/login" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">{{ trans_db('staff_login') }}</a>
                    </div>
                    
                    <div class="h-6 w-px bg-slate-200 hidden md:block"></div>
                    
                    {{-- Language Switcher --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 text-xs font-bold uppercase tracking-tight text-slate-700 hover:bg-slate-50 transition border border-slate-200 rounded-xl">
                            <span>
                                @if(app()->getLocale() == 'en') EN
                                @elseif(app()->getLocale() == 'hi') HI
                                @elseif(app()->getLocale() == 'gu') GU
                                @elseif(app()->getLocale() == 'mr') MR
                                @endif
                            </span>
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50">
                            @foreach(['en' => 'English', 'hi' => 'हिंदी', 'gu' => 'ગુજરાતી', 'mr' => 'मराठी'] as $code => $label)
                                <a href="/lang/{{ $code }}" class="flex items-center justify-between px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 transition">
                                    <span>{{ $label }}</span>
                                    @if(app()->getLocale() == $code)
                                        <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Mini Hero / Header Area --}}
    <div class="relative py-12 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero.png') }}" class="w-full h-full object-cover opacity-30 blur-sm scale-105" alt="">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/50 to-slate-900"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                {{ trans_db('choose_your_room') }}
            </h2>
            <p class="text-slate-300 max-w-2xl mx-auto text-sm md:text-base">
                {{ trans_db('welcome_subtitle') }}
            </p>
        </div>
    </div>

    {{-- Main Content Window --}}
    <div class="container mx-auto px-4 -mt-10 pb-20 relative z-10">
        <div class="bg-white/90 backdrop-blur-2xl rounded-[32px] shadow-[0_32px_128px_-16px_rgba(0,0,0,0.06)] border border-white/50 overflow-hidden">
            
            {{-- Stepper Navigation --}}
            <div class="bg-slate-50/50 border-b border-slate-100 px-6 py-6 md:px-12">
                <div class="flex items-center justify-between max-w-4xl mx-auto overflow-x-auto no-scrollbar">
                    @foreach([
                            ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'select_dates'],
                            ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'choose_room'],
                            ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'guest_details'],
                            ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'confirmation']
                        ] as $index => $s)
                                        @php $stepNum = $index + 1; @endphp
                                        <div class="flex items-center group transition flex-shrink-0 {{ !$loop->last ? 'flex-1' : '' }}">
                                            <div class="flex flex-col items-center">
                                                <div class="relative">
                                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 {{ $step == $stepNum ? 'bg-blue-600 text-white shadow-xl shadow-blue-200 scale-110' : ($step > $stepNum ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'bg-white border border-slate-200 text-slate-400') }}">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"></path>
                                                        </svg>
                                                    </div>
                                                    @if($step > $stepNum)
                                                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center">
                                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span class="text-[10px] md:text-xs font-bold mt-3 uppercase tracking-widest {{ $step == $stepNum ? 'text-blue-600' : 'text-slate-400' }}">
                                                    {{ trans_db($s['label']) }}
                                                </span>
                                            </div>
                                            @if(!$loop->last)
                                                <div class="hidden md:block flex-1 h-0.5 mx-6 rounded-full overflow-hidden bg-slate-200">
                                                    <div class="h-full bg-blue-600 transition-all duration-700" style="width: {{ $step > $stepNum ? '100%' : ($step == $stepNum ? '0%' : '0%') }}"></div>
                                                </div>
                                            @endif
                                        </div>
                    @endforeach
                </div>
            </div>

            <div class="p-8 md:p-14">
                {{-- Step 1: Date Selection --}}
                @if($step == 1)
                    <div class="max-w-xl mx-auto" x-data="{ reveal: true }" x-init="reveal = true">
                        <div class="text-center mb-12">
                            <h3 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2">{{ trans_db('when_stay') }}</h3>
                            <p class="text-slate-500">Plan your peaceful stay with us</p>
                        </div>

                        <div class="space-y-8">
                            <div class="grid grid-cols-1 gap-6">
                                <div class="space-y-3">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('checkin_date') }}</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition group-focus-within:text-blue-600">
                                            <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <input type="datetime-local" wire:model.live="check_in" class="w-full pl-14 pr-4 py-5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all text-slate-900 font-bold text-lg uppercase tracking-tight">
                                    </div>
                                    @error('check_in') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-3">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('checkout_date') }}</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition text-slate-400">
                                            <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <input type="datetime-local" wire:model="check_out" readonly class="w-full pl-14 pr-4 py-5 bg-slate-100/80 border-none rounded-2xl cursor-not-allowed text-slate-600 font-bold text-lg uppercase tracking-tight">
                                    </div>
                                    @error('check_out') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('number_of_guests') }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <select wire:model="guests" class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all text-slate-700 font-medium appearance-none">
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? trans_db('guest') : trans_db('guests') }}</option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <button wire:click="searchRooms" class="w-full py-5 bg-blue-600 text-white rounded-[20px] font-bold text-lg hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 active:scale-95 flex items-center justify-center space-x-3 group">
                                <span>{{ trans_db('search_available_rooms') }}</span>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Step 2: Room Selection (Room Map) --}}
                @if($step == 2)
                    <div class="space-y-12">
                        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-slate-100 pb-8 gap-4">
                            <div>
                                <h3 class="text-3xl font-bold text-slate-900 mb-2">{{ trans_db('choose_your_room') }}</h3>
                                <p class="text-slate-500 font-medium flex items-center">
                                    <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                                    {{ $nights }} {{ $nights == 1 ? trans_db('night') : trans_db('nights') }} stay for {{ $guests }} {{ $guests == 1 ? trans_db('guest') : trans_db('guests') }}
                                </p>
                            </div>
                            <button wire:click="$set('step', 1)" class="text-sm font-bold text-blue-600 hover:text-blue-700 transition px-4 py-2 bg-blue-50 rounded-xl">
                                Edit Search
                            </button>
                        </div>

                        {{-- Building Selector (Premium Pill Style) --}}
                        <div class="flex justify-center">
                            <div class="inline-flex p-1.5 bg-slate-100/80 backdrop-blur-sm rounded-[20px] border border-slate-200/50 shadow-sm">
                                @foreach($buildings as $b)
                                    <button 
                                        wire:click="selectBuilding({{ $b->id }})"
                                        class="relative px-8 py-2.5 rounded-[14px] text-xs font-black uppercase tracking-widest transition-all duration-500 overflow-hidden {{ $selectedBuildingId == $b->id ? 'bg-white text-blue-600 shadow-md translate-y-0' : 'text-slate-500 hover:text-slate-800' }}">
                                        {{ $b->name }}
                                        @if($selectedBuildingId == $b->id)
                                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1 h-1 bg-blue-600 rounded-full mb-1"></div>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Room Map Layout (Premium Design) --}}
                        @php
                            $currentBuilding = collect($buildings)->firstWhere('id', $selectedBuildingId);
                        @endphp

                        @if($currentBuilding)
                            <div class="space-y-16">
                                @foreach($currentBuilding->floors as $floor)
                                    <div class="space-y-8">
                                        {{-- Elegant Floor Header --}}
                                        <div class="flex items-center space-x-6">
                                            <div class="flex-shrink-0 flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-[10px] font-black text-white shadow-xl shadow-slate-200">
                                                    {{ substr($floor->floor_number, 0, 1) }}
                                                </div>
                                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-[0.3em]">{{ $floor->floor_number }}</h4>
                                            </div>
                                            <div class="h-[1px] flex-1 bg-gradient-to-r from-slate-200 to-transparent"></div>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8">
                                            @foreach($floor->rooms as $room)
                                                @php
                                                    $isAvailable = $room->status === 'available';
                                                    $isTooSmall = $room->roomCategory->capacity < $guests;
                                                    $canSelect = $isAvailable && !$isTooSmall;

                                                    // Dynamic styling based on category
                                                    $catColor = match (true) {
                                                        str_contains(strtolower($room->roomCategory->name), 'premium') => 'amber',
                                                        str_contains(strtolower($room->roomCategory->name), 'deluxe') => 'blue',
                                                        default => 'slate'
                                                    };
                                                @endphp

                                                <button 
                                                    @if($canSelect) wire:click="selectRoom({{ $room->roomCategory->id }}, {{ $room->id }})" @endif
                                                    class="relative group rounded-[2.5rem] p-8 transition-all duration-500 {{ $canSelect ? 'bg-white border border-slate-100 hover:border-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-2' : 'bg-slate-50/50 border border-transparent opacity-40 cursor-not-allowed grayscale' }}">

                                                    <div class="flex flex-col items-center text-center space-y-4">
                                                        {{-- Room Category Tag --}}
                                                        <span class="px-3 py-1 bg-{{ $catColor }}-50 text-{{ $catColor }}-500 text-[8px] font-black uppercase tracking-widest rounded-full">
                                                            {{ $room->roomCategory->name }}
                                                        </span>

                                                        {{-- Decorative Icon --}}
                                                        <div class="relative">
                                                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-500 {{ $canSelect ? 'bg-blue-50 text-blue-600 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white shadow-lg shadow-blue-50' : 'bg-slate-100 text-slate-400' }}">
                                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                                </svg>
                                                            </div>
                                                            @if($canSelect)
                                                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                                                            @endif
                                                        </div>

                                                        <div>
                                                            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ $room->room_number }}</p>
                                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Room Number</p>
                                                        </div>

                                                        <div class="pt-2">
                                                            @if($canSelect)
                                                                <p class="text-sm font-black text-blue-600">₹{{ number_format($room->roomCategory->base_tariff, 0) }}</p>
                                                            @else
                                                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest bg-slate-200/50 px-2 py-1 rounded-md">
                                                                    {{ $isTooSmall ? 'Small Cap' : ucfirst($room->status) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Selection indicator on hover --}}
                                                    @if($canSelect)
                                                        <div class="absolute inset-x-0 -bottom-2 flex justify-center opacity-0 group-hover:opacity-100 group-hover:bottom-4 transition-all duration-500">
                                                            <span class="text-[9px] font-black text-white uppercase tracking-[0.2em] bg-blue-600 px-4 py-1.5 rounded-full shadow-lg shadow-blue-200">Book Now</span>
                                                        </div>
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Refined Legend --}}
                        <div class="max-w-2xl mx-auto">
                            <div class="bg-white border border-slate-100 shadow-xl shadow-slate-100 rounded-[2.5rem] p-10 flex flex-wrap gap-12 items-center justify-center">
                                <div class="flex items-center space-x-4">
                                    <div class="w-4 h-4 rounded-lg bg-white border-2 border-slate-200 shadow-sm"></div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Available</span>
                                        <span class="text-[9px] text-slate-400 font-medium">Ready for booking</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-4 h-4 rounded-lg bg-slate-200 shadow-sm"></div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Unavailable</span>
                                        <span class="text-[9px] text-slate-400 font-medium">Occupied or maintenance</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-4 h-4 rounded-lg bg-blue-600 shadow-xl shadow-blue-200"></div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Selection</span>
                                        <span class="text-[9px] text-slate-400 font-medium">Click to select</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Step 3: Guest Information --}}
                @if($step == 3)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-14">
                        <div class="lg:col-span-2 space-y-10">
                            <div>
                                <h3 class="text-3xl font-bold text-slate-900 mb-2">{{ trans_db('your_details') }}</h3>
                                <p class="text-slate-500">Please provide accurate information for your reservation</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('first_name') }} <span class="text-red-400">*</span></label>
                                    <input type="text" wire:model="first_name" placeholder="E.g. Arvind" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all text-slate-700 font-medium">
                                    @error('first_name') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('last_name') }}</label>
                                    <input type="text" wire:model="last_name" placeholder="E.g. Sharma" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all text-slate-700 font-medium">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('mobile_number') }} <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-400 border-r border-slate-200 my-4 h-6 px-3">
                                        <span class="text-sm font-bold">+91</span>
                                    </div>
                                    <input type="tel" wire:model="mobile_number" class="w-full pl-16 pr-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all text-slate-700 font-medium tracking-wide">
                                </div>
                                @error('mobile_number') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('email_optional') }}</label>
                                <input type="email" wire:model="email" placeholder="arvind@example.com" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all text-slate-700 font-medium">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ trans_db('special_requests') }}</label>
                                <textarea wire:model="special_requests" rows="3" placeholder="{{ trans_db('any_special_requirements') }}" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all text-slate-700 font-medium"></textarea>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="sticky top-28 bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-200">
                                <h4 class="text-xl font-bold mb-8 flex items-center pb-6 border-b border-white/10 uppercase tracking-widest text-xs">
                                    Your Summary
                                </h4>

                                <div class="space-y-6 mb-10">
                                    <div class="flex justify-between items-start">
                                        <div class="space-y-1">
                                            <span class="text-[10px] font-black uppercase tracking-tighter text-blue-100">Details</span>
                                            <p class="font-bold">{{ $nights }} {{ $nights == 1 ? trans_db('night') : trans_db('nights') }} Stay</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <div class="space-y-1">
                                            <span class="text-[10px] font-black uppercase tracking-tighter text-blue-100">Check-In</span>
                                            <p class="font-bold text-sm">{{ Carbon\Carbon::parse($check_in)->format('d M, H:i') }}</p>
                                        </div>
                                        <div class="text-right space-y-1">
                                            <span class="text-[10px] font-black uppercase tracking-tighter text-blue-100">Check-Out</span>
                                            <p class="font-bold text-sm">{{ Carbon\Carbon::parse($check_out)->format('d M, H:i') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-8 border-t border-white/20">
                                    <div class="flex items-center justify-between mb-8">
                                        <span class="text-sm font-medium text-blue-100">{{ trans_db('total_amount') }}</span>
                                        <span class="text-4xl font-extrabold">₹{{ number_format($total_amount, 0) }}</span>
                                    </div>
                                    <button wire:click="confirmBooking" class="w-full py-5 bg-white text-blue-600 rounded-2xl font-black text-lg hover:bg-blue-50 transition-all active:scale-95 shadow-xl">
                                        {{ trans_db('confirm_booking') }}
                                    </button>
                                    <p class="text-center text-[10px] text-blue-200 font-bold uppercase tracking-widest mt-6">Secure Reservation</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Step 4: Confirmation --}}
                @if($step == 4)
                    <div class="max-w-3xl mx-auto text-center py-10" x-data="{ reveal: false }" x-init="setTimeout(() => reveal = true, 100)">
                        <div x-show="reveal" x-transition.scale.origin.bottom class="w-32 h-32 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-10 shadow-2xl shadow-emerald-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                        </div>

                        <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">{{ trans_db('booking_confirmed') }}</h2>
                        <p class="text-xl text-slate-500 mb-12">{{ trans_db('thank_you_booking', ['name' => $first_name]) }}</p>

                        <div class="bg-slate-50 rounded-[2.5rem] p-10 md:p-14 text-left grid grid-cols-1 md:grid-cols-3 gap-10 border border-slate-100">
                            <div class="md:col-span-1 space-y-8">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400 block mb-2">{{ trans_db('checkin') }}</span>
                                    <p class="text-2xl font-black text-slate-900 leading-tight">
                                        {{ Carbon\Carbon::parse($check_in)->format('d') }}<br>
                                        <span class="text-xs uppercase tracking-widest text-blue-600">{{ Carbon\Carbon::parse($check_in)->format('M Y') }}</span>
                                        <span class="block text-[10px] text-slate-400 mt-1 font-bold">{{ Carbon\Carbon::parse($check_in)->format('H:i') }}</span>
                                    </p>
                                </div>
                                <div class="w-px h-10 bg-slate-200 hidden md:block"></div>
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400 block mb-2">{{ trans_db('checkout') }}</span>
                                    <p class="text-2xl font-black text-slate-900 leading-tight">
                                        {{ Carbon\Carbon::parse($check_out)->format('d') }}<br>
                                        <span class="text-xs uppercase tracking-widest text-blue-600">{{ Carbon\Carbon::parse($check_out)->format('M Y') }}</span>
                                        <span class="block text-[10px] text-slate-400 mt-1 font-bold">{{ Carbon\Carbon::parse($check_out)->format('H:i') }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                                <div class="flex justify-between items-center text-sm font-bold">
                                    <span class="text-slate-400 uppercase tracking-widest">{{ trans_db('guests') }}</span>
                                    <span class="text-slate-900">{{ $guests }} {{ $guests == 1 ? 'Person' : 'Persons' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm font-bold">
                                    <span class="text-slate-400 uppercase tracking-widest">Mobile</span>
                                    <span class="text-slate-900">{{ $mobile_number }}</span>
                                </div>
                                <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                                    <span class="text-lg font-bold text-slate-900">{{ trans_db('total_amount') }}</span>
                                    <span class="text-3xl font-black text-blue-600">₹{{ number_format($total_amount, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-16 flex flex-col md:flex-row items-center justify-center gap-6">
                            <a href="/book" class="w-full md:w-auto px-10 py-5 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 transition shadow-xl shadow-blue-100">
                                {{ trans_db('book_another_room') }}
                            </a>
                            <button onclick="window.print()" class="w-full md:w-auto px-10 py-5 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition">
                                Print Receipt
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            width: 100%;
            position: absolute;
            left: 0;
            cursor: pointer;
        }
    </style>
</div>
