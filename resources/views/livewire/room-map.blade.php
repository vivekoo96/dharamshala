<div class="space-y-6">
    {{-- Header Stats --}}
    @php
        $rooms = $building?->floors->flatMap->rooms ?? collect();
        $total = $rooms->count();
        $available = $rooms->filter(fn($r) => $r->remaining_beds > 0 && $r->status !== 'maintenance')->count();
        $occupied = $rooms->filter(fn($r) => $r->remaining_beds <= 0 && $r->status !== 'maintenance')->count();
        $maintenance = $rooms->where('status', 'maintenance')->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">
                        {{ trans_db('total_rooms') }}</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $total }}</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-xl">
                    <i data-lucide="building-2" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">
                        {{ trans_db('available') }}</p>
                    <p class="text-3xl font-black text-emerald-600 mt-2">{{ $available }}</p>
                </div>
                <div class="bg-emerald-50 p-3 rounded-xl">
                    <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">
                        {{ trans_db('occupied') }}</p>
                    <p class="text-3xl font-black text-red-600 mt-2">{{ $occupied }}</p>
                </div>
                <div class="bg-red-50 p-3 rounded-xl">
                    <i data-lucide="users" class="w-6 h-6 text-red-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">
                        {{ trans_db('maintenance') }}</p>
                    <p class="text-3xl font-black text-amber-600 mt-2">{{ $maintenance }}</p>
                </div>
                <div class="bg-amber-50 p-3 rounded-xl">
                    <i data-lucide="wrench" class="w-6 h-6 text-amber-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Building Selector --}}
    <div class="bg-white rounded-2xl shadow-sm p-4 border border-slate-200">
        <div class="flex items-center space-x-3">
            <span
                class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">{{ trans_db('select_building') }}:</span>
            @foreach($buildings as $b)
                <button wire:click="selectBuilding({{ $b->id }})"
                    class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $selectedBuildingId == $b->id ? 'bg-blue-600 text-white shadow-lg' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                    {{ $b->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Room Grid by Floor --}}
    @if($building)
        <div class="space-y-8">
            @foreach($building->floors->sortByDesc('floor_number') as $floor)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-sm font-black text-white uppercase tracking-[0.3em]">
                            @if($floor->floor_number == 0) THE GROUND FLOOR @else FLOOR {{ $floor->floor_number }} @endif
                        </h3>
                        <span class="text-[10px] font-bold text-blue-100 uppercase tracking-widest">{{ $floor->rooms->count() }}
                            ROOMS</span>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                            @foreach($floor->rooms as $room)
                                @php
                                    $isFull = $room->remaining_beds <= 0;
                                    $isMaintenance = $room->status === 'maintenance';
                                    $isCleaning = $room->status === 'cleaning';

                                    $borderColor = 'border-emerald-500';
                                    $bgColor = 'bg-white';
                                    $statusLabel = 'AVAILABLE';
                                    $statusColor = 'text-emerald-500';

                                    if ($isMaintenance) {
                                        $borderColor = 'border-slate-200';
                                        $bgColor = 'bg-slate-50 opacity-60';
                                        $statusLabel = 'MAINTENANCE';
                                        $statusColor = 'text-amber-600';
                                    } elseif ($isFull) {
                                        $borderColor = 'border-red-100';
                                        $bgColor = 'bg-red-50';
                                        $statusLabel = 'ROOM FULL';
                                        $statusColor = 'text-red-500';
                                    } elseif ($room->occupied_beds_count > 0) {
                                        $statusLabel = 'SHARING';
                                        $statusColor = 'text-blue-500';
                                        $borderColor = 'border-emerald-300';
                                    }

                                    if ($isCleaning) {
                                        $statusLabel = 'CLEANING';
                                        $statusColor = 'text-blue-600';
                                        $borderColor = 'border-blue-200';
                                    }
                                @endphp

                                <div
                                    class="relative group border-2 rounded-2xl p-5 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 {{ $borderColor }} {{ $bgColor }} flex flex-col items-center justify-between min-h-[160px]">
                                    <div class="w-full text-center space-y-1 mb-4">
                                        <p class="text-2xl font-black tracking-tighter leading-none text-slate-900">
                                            {{ $room->room_number }}</p>
                                        <p class="text-[8px] font-bold uppercase tracking-widest opacity-60 text-slate-500">
                                            {{ $room->roomCategory->name }}</p>
                                    </div>

                                    <div class="w-full text-center space-y-4">
                                        <div class="flex flex-col items-center">
                                            <span
                                                class="text-[9px] font-black uppercase tracking-[0.2em] {{ $statusColor }}">{{ $statusLabel }}</span>
                                            <span
                                                class="text-[10px] font-bold text-slate-400 tabular-nums">₹{{ number_format($room->roomCategory->base_tariff, 0) }}</span>
                                        </div>

                                        {{-- Bed Occupancy Indicator --}}
                                        <div class="w-full space-y-1.5 px-2">
                                            <div class="flex justify-between items-center text-[8px] font-black text-slate-400">
                                                <span>BEDS</span>
                                                <span>{{ $room->occupied_beds_count }}/{{ $room->roomCategory->capacity }}</span>
                                            </div>
                                            <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden border border-slate-50">
                                                <div class="h-full transition-all duration-500 {{ $isFull ? 'bg-red-500' : 'bg-emerald-500' }}"
                                                    style="width:{{ ($room->occupied_beds_count / $room->roomCategory->capacity) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status Icon Overlay --}}
                                    <div class="absolute top-3 right-3 opacity-20 group-hover:opacity-100 transition-all">
                                        @if($statusLabel === 'AVAILABLE' || $statusLabel === 'SHARING')
                                            <i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                        @elseif($isMaintenance)
                                            <i data-lucide="wrench" class="w-4 h-4 text-amber-500"></i>
                                        @elseif($isFull)
                                            <i data-lucide="users" class="w-4 h-4 text-red-500"></i>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Legend --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">{{ trans_db('status_legend') }}
        </h4>
        <div class="flex flex-wrap gap-8">
            <div class="flex items-center space-x-3">
                <div class="w-5 h-5 bg-white border-2 border-emerald-500 rounded-lg"></div>
                <span class="text-xs font-bold text-slate-600">Available</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-5 h-5 bg-white border-2 border-emerald-300 rounded-lg flex items-center justify-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                </div>
                <span class="text-xs font-bold text-slate-600">Sharing / Partial</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-5 h-5 bg-red-50 border-2 border-red-100 rounded-lg"></div>
                <span class="text-xs font-bold text-slate-600">Occupied (Full)</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-5 h-5 bg-slate-50 border-2 border-slate-200 rounded-lg opacity-60"></div>
                <span class="text-xs font-bold text-slate-600">Maintenance</span>
            </div>
        </div>
    </div>
</div>