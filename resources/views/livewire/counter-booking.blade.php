@php
    $stats = $this->buildingStats;
@endphp

<div class="min-h-screen bg-slate-50 pb-12">
    {{-- Top Stats Bar - Full Width Style --}}
    <div class="bg-white border-b border-slate-200 mb-6 shadow-sm">
        <div class="max-w-[99%] mx-auto px-4 py-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Total Rooms --}}
                <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ trans_db('total_rooms') }}</p>
                        <p class="text-3xl font-black text-slate-900 leading-none">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="building-2" class="w-5 h-5 text-blue-600"></i>
                    </div>
                </div>

                {{-- Available (Beds Free) --}}
                <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ trans_db('available') }}</p>
                        <p class="text-3xl font-black text-emerald-600 leading-none">{{ $stats['available'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                    </div>
                </div>

                {{-- Occupied (Full) --}}
                <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ trans_db('occupied') }}</p>
                        <p class="text-3xl font-black text-red-600 leading-none">{{ $stats['occupied'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="w-5 h-5 text-red-600"></i>
                    </div>
                </div>

                {{-- Maintenance --}}
                <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ trans_db('maintenance') }}</p>
                        <p class="text-3xl font-black text-amber-600 leading-none">{{ $stats['maintenance'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="wrench" class="w-5 h-5 text-amber-600"></i>
                    </div>
                </div>
            </div>

            {{-- Building Selector Tab Row --}}
            <div class="mt-8 flex items-center gap-3">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2">{{ trans_db('select_building') }}:</span>
                <div class="flex gap-2 bg-slate-100 p-1 rounded-xl border border-slate-200">
                    @foreach($buildings as $building)
                        <button 
                            wire:click="selectBuilding({{ $building->id }})"
                            class="px-5 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $selectedBuildingId == $building->id ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-600 hover:bg-white hover:text-blue-600' }}">
                            {{ $building->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[99%] mx-auto px-2 md:px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Left Column: Guest Info & Billing (5/12) --}}
            <div class="lg:col-span-5 space-y-6">
                {{-- STEP 1: Guest Details --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                            <h2 class="text-base font-bold text-slate-800">{{ trans_db('guest_details') }}</h2>
                        </div>
                        <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wider">Step 1</span>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ trans_db('first_name') }}</label>
                                <input type="text" wire:model="first_name" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-slate-50/50" placeholder="First Name">
                                @error('first_name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ trans_db('last_name') }}</label>
                                <input type="text" wire:model="last_name" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-slate-50/50" placeholder="Last Name">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ trans_db('mobile_number') }}</label>
                            <input type="tel" wire:model="mobile_number" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-slate-50/50" placeholder="10-digit mobile">
                            @error('mobile_number') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ trans_db('id_type') }}</label>
                                <select wire:model="id_type" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-slate-50/50">
                                    <option value="aadhaar">Aadhaar Card</option>
                                    <option value="passport">Passport</option>
                                    <option value="voter_id">Voter ID</option>
                                    <option value="driving_license">Driving License</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ trans_db('id_number') }}</label>
                                <input type="text" wire:model="id_number" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-slate-50/50" placeholder="ID Number">
                            </div>
                        </div>

                        {{-- ID Proof Overlay --}}
                        <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-blue-400 transition-all bg-slate-50">
                            <input type="file" wire:model="id_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                            <div wire:loading wire:target="id_image" class="absolute inset-0 bg-white/90 backdrop-blur-sm flex items-center justify-center rounded-2xl z-30">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            </div>
                            <i data-lucide="camera" class="mx-auto w-8 h-8 text-slate-300 mb-2 group-hover:text-blue-500 transition-colors"></i>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $id_image ? 'FILE READY' : 'CLICK TO UPLOAD ID PROOF' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ trans_db('check_in') }}</label>
                                <input type="datetime-local" wire:model="check_in" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ trans_db('check_out') }}</label>
                                <input type="datetime-local" wire:model="check_out" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3 pt-4">
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Adult (M)</p>
                                <div class="flex items-center justify-center gap-4">
                                    <button wire:click="$set('adults_male', {{ max(0, $adults_male - 1) }})" class="text-slate-400 hover:text-blue-600"><i data-lucide="minus-circle" class="w-5 h-5"></i></button>
                                    <span class="text-lg font-black">{{ $adults_male }}</span>
                                    <button wire:click="$set('adults_male', {{ $adults_male + 1 }})" class="text-blue-600 hover:text-blue-800"><i data-lucide="plus-circle" class="w-5 h-5"></i></button>
                                </div>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Adult (F)</p>
                                <div class="flex items-center justify-center gap-4">
                                    <button wire:click="$set('adults_female', {{ max(0, $adults_female - 1) }})" class="text-slate-400 hover:text-blue-600"><i data-lucide="minus-circle" class="w-5 h-5"></i></button>
                                    <span class="text-lg font-black">{{ $adults_female }}</span>
                                    <button wire:click="$set('adults_female', {{ $adults_female + 1 }})" class="text-blue-600 hover:text-blue-800"><i data-lucide="plus-circle" class="w-5 h-5"></i></button>
                                </div>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Children</p>
                                <div class="flex items-center justify-center gap-4">
                                    <button wire:click="$set('children', {{ max(0, $children - 1) }})" class="text-slate-400 hover:text-blue-600"><i data-lucide="minus-circle" class="w-5 h-5"></i></button>
                                    <span class="text-lg font-black">{{ $children }}</span>
                                    <button wire:click="$set('children', {{ $children + 1 }})" class="text-blue-600 hover:text-blue-800"><i data-lucide="plus-circle" class="w-5 h-5"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: Billing & Payment --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-8">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="credit-card" class="w-5 h-5 text-blue-600"></i>
                            <h2 class="text-base font-bold text-slate-800">{{ trans_db('billing_payment') }}</h2>
                        </div>
                        <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wider">Step 3</span>
                    </div>

                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(['cash' => 'banknote', 'upi' => 'smartphone', 'card' => 'credit-card'] as $mode => $icon)
                                <button wire:click="$set('payment_mode', '{{ $mode }}')"
                                    class="flex flex-col items-center py-4 rounded-2xl border-2 transition-all {{ $payment_mode === $mode ? 'bg-blue-600 border-blue-600 text-white shadow-xl shadow-blue-100 scale-105' : 'bg-slate-50 border-transparent text-slate-500 hover:bg-slate-100' }}">
                                    <i data-lucide="{{ $icon }}" class="w-6 h-6 mb-2"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest">{{ trans_db($mode) }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="flex-1">
                                    <label class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1.5">Apply Discount (₹)</label>
                                    <input type="number" wire:model.live="discount" class="w-full px-4 py-2 text-sm border border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-100 font-bold" placeholder="0">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1.5">Reason</label>
                                    <input type="text" wire:model="discount_reason" class="w-full px-4 py-2 text-sm border border-blue-200 rounded-xl" placeholder="Reason">
                                </div>
                            </div>

                            <div class="pt-4 border-t border-blue-100 space-y-2">
                                <div class="flex justify-between text-xs font-bold text-slate-500">
                                    <span>Subtotal</span>
                                    <span>₹{{ number_format($this->totalTariff + $this->totalDeposit, 0) }}</span>
                                </div>
                                @if($discount > 0)
                                    <div class="flex justify-between text-xs font-bold text-emerald-600">
                                        <span>Discount</span>
                                        <span>- ₹{{ number_format($discount, 0) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between pt-2">
                                    <span class="text-sm font-black text-slate-900 uppercase tracking-widest">Total Payable</span>
                                    <span class="text-3xl font-black text-blue-600">₹{{ number_format($this->totalPayable, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button wire:click="resetForm" class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">Reset</button>
                            <button wire:click="createBooking" @if(count($selected_rooms) == 0 || $this->selectedCapacity < ($adults_male + $adults_female)) disabled @endif
                                class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-blue-100 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all active:scale-95">
                                {{ trans_db('confirm_booking') }}
                            </button>
                        </div>
                        @if($this->selectedCapacity < ($adults_male + $adults_female))
                            <p class="text-[10px] font-bold text-orange-500 text-center uppercase tracking-tighter">Need {{ ($adults_male + $adults_female) - $this->selectedCapacity }} more spots in rooms.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Room Map Interface (7/12) --}}
            <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-[calc(100vh-140px)] sticky top-8">
                <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="grid-3x3" class="w-6 h-6 text-white"></i>
                        <h2 class="text-lg font-black text-white uppercase tracking-wider">{{ trans_db('room_selection') }}</h2>
                    </div>
                    <div class="flex gap-2">
                        @foreach($room_categories as $cat)
                            <button wire:click="setFilter({{ $cat->id }})" 
                                class="px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-lg transition-all {{ $filter_category_id == $cat->id ? 'bg-white text-blue-600 shadow-lg' : 'bg-blue-500 text-white/80 hover:bg-blue-400' }}">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                        <button wire:click="setFilter(null)" class="px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-lg transition-all {{ is_null($filter_category_id) ? 'bg-white text-blue-600 shadow-lg' : 'bg-blue-500 text-white/80 hover:bg-blue-400' }}">All</button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6 space-y-12 custom-scrollbar">
                    @php
                        $currentBuilding = $this->currentBuilding;
                    @endphp

                    @if($currentBuilding)
                        @foreach($currentBuilding->floors->sortByDesc('floor_number') as $floor)
                            <div class="space-y-6">
                                {{-- Floor Blue Banner --}}
                                <div class="bg-blue-600 rounded-xl px-6 py-3 shadow-md border-b-4 border-blue-700 flex items-center justify-between">
                                    <h3 class="text-sm font-black text-white uppercase tracking-[0.3em]">
                                        @if($floor->floor_number == 0) THE GROUND FLOOR @else FLOOR {{ $floor->floor_number }} @endif
                                    </h3>
                                    <span class="text-[10px] font-bold text-blue-100 uppercase tracking-widest">{{ $floor->rooms->count() }} ROOMS</span>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                                    @foreach($floor->rooms as $room)
                                        @php
                                            $isSelected = in_array($room->id, $selected_rooms);
                                            $isFull = $room->remaining_beds <= 0;
                                            $canSelect = $room->remaining_beds >= ($adults_male + $adults_female);
                                            $isMaintenance = $room->status === 'maintenance';
                                            
                                            $uiClass = 'bg-white border-2 hover:shadow-xl hover:-translate-y-1';
                                            $borderColor = 'border-slate-100';
                                            $statusLabel = 'AVAILABLE';
                                            $statusColor = 'text-emerald-500';

                                            if ($isSelected) {
                                                $uiClass = 'bg-blue-600 border-blue-700 shadow-xl shadow-blue-100 text-white';
                                                $borderColor = 'border-blue-700';
                                                $statusLabel = 'SELECTED';
                                                $statusColor = 'text-white/80';
                                            } elseif ($isMaintenance) {
                                                $uiClass = 'bg-slate-50 border-slate-200 opacity-60 grayscale cursor-not-allowed';
                                                $statusLabel = 'MAINTENANCE';
                                                $statusColor = 'text-amber-600';
                                            } elseif ($isFull) {
                                                $uiClass = 'bg-red-50 border-red-100 opacity-80 cursor-not-allowed';
                                                $statusLabel = 'ROOM FULL';
                                                $statusColor = 'text-red-500';
                                            } elseif ($room->occupied_beds_count > 0) {
                                                $statusLabel = 'SHARING';
                                                $statusColor = 'text-blue-500';
                                                $borderColor = 'border-emerald-300';
                                            } else {
                                                $borderColor = 'border-emerald-500';
                                            }
                                        @endphp
                                        
                                        <button 
                                            wire:key="cnt-room-{{ $room->id }}"
                                            type="button" 
                                            @if(($canSelect || $isSelected) && !$isMaintenance) wire:click="toggleRoom({{ $room->id }})" @endif
                                            @if($isMaintenance || (!$canSelect && !$isSelected)) disabled @endif
                                            class="p-4 rounded-2xl flex flex-col items-center justify-between transition-all duration-300 {{ $uiClass }} {{ $borderColor }} group relative overflow-hidden">
                                            
                                            @if($isSelected)
                                                <div class="absolute top-2 right-2">
                                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-white"></i>
                                                </div>
                                            @elseif($statusLabel === 'AVAILABLE' || $statusLabel === 'SHARING')
                                                <div class="absolute top-2 right-2">
                                                    <i data-lucide="check" class="w-4 h-4 text-emerald-500 opacity-50"></i>
                                                </div>
                                            @endif

                                            <div class="w-full text-center space-y-1 mb-4">
                                                <p class="text-2xl font-black tracking-tighter leading-none">{{ $room->room_number }}</p>
                                                <p class="text-[8px] font-bold uppercase tracking-widest opacity-60">{{ $room->roomCategory->name }}</p>
                                            </div>

                                            <div class="w-full text-center space-y-3">
                                                <div class="flex flex-col items-center">
                                                    <span class="text-[9px] font-black uppercase tracking-[0.2em] {{ $statusColor }}">{{ $statusLabel }}</span>
                                                    <span class="text-[10px] font-bold opacity-80 tabular-nums">₹{{ number_format($room->roomCategory->base_tariff, 0) }}</span>
                                                </div>

                                                {{-- Bed Occupancy Indicator --}}
                                                <div class="w-full space-y-1 px-2">
                                                    <div class="flex justify-between items-center text-[8px] font-black">
                                                        <span class="opacity-70">BEDS</span>
                                                        <span>{{ $room->occupied_beds_count }}/{{ $room->roomCategory->capacity }}</span>
                                                    </div>
                                                    <div class="h-1.5 bg-black/5 rounded-full overflow-hidden border border-black/5">
                                                        <div class="h-full transition-all duration-500 {{ $isSelected ? 'bg-white' : ($isFull ? 'bg-red-500' : 'bg-emerald-500') }}" style="width:{{ ($room->occupied_beds_count / $room->roomCategory->capacity) * 100 }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Dashboard Legend Bar --}}
                <div class="bg-slate-50 border-t border-slate-200 px-6 py-4 flex items-center justify-center space-x-8">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded-lg bg-white border-2 border-emerald-500"></div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Available</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded-lg bg-blue-600 shadow-lg"></div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Selected</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded-lg bg-slate-100 border-2 border-slate-200 opacity-60"></div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Maintenance</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</div>