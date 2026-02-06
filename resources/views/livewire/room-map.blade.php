<div class="space-y-6">
    {{-- Header Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">{{ trans_db('total_rooms') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $building?->floors->sum(fn($f) => $f->rooms->count()) ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">{{ trans_db('available') }}</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $building?->floors->sum(fn($f) => $f->rooms->where('status', 'available')->count()) ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">{{ trans_db('occupied') }}</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $building?->floors->sum(fn($f) => $f->rooms->where('status', 'occupied')->count()) ?? 0 }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">{{ trans_db('maintenance') }}</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $building?->floors->sum(fn($f) => $f->rooms->where('status', 'maintenance')->count()) ?? 0 }}</p>
                </div>
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Building Selector --}}
    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
        <div class="flex items-center space-x-3">
            <span class="text-sm font-medium text-gray-700">{{ trans_db('select_building') }}:</span>
            @foreach($buildings as $building)
                <button 
                    wire:click="selectBuilding({{ $building->id }})"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $selectedBuildingId == $building->id ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $building->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Room Grid by Floor --}}
    @if($building)
        <div class="space-y-6">
            @foreach($building->floors as $floor)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-blue-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">{{ $floor->floor_number }}</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach($floor->rooms as $room)
                                @php
                                    $statusColors = [
                                        'available' => 'bg-green-50 border-green-300 hover:border-green-500',
                                        'occupied' => 'bg-red-50 border-red-300 hover:border-red-500',
                                        'maintenance' => 'bg-amber-50 border-amber-300 hover:border-amber-500',
                                        'cleaning' => 'bg-blue-50 border-blue-300 hover:border-blue-500'
                                    ];
                                    $statusIcons = [
                                        'available' => '✓',
                                        'occupied' => '●',
                                        'maintenance' => '⚙',
                                        'cleaning' => '◐'
                                    ];
                                    $statusTextColors = [
                                        'available' => 'text-green-700',
                                        'occupied' => 'text-red-700',
                                        'maintenance' => 'text-amber-700',
                                        'cleaning' => 'text-blue-700'
                                    ];
                                @endphp
                                
                                <div class="relative group cursor-pointer {{ $statusColors[$room->status] }} border-2 rounded-lg p-4 transition-all duration-200 hover:shadow-md">
                                    <div class="flex flex-col items-center space-y-2">
                                        <div class="text-2xl {{ $statusTextColors[$room->status] }}">{{ $statusIcons[$room->status] }}</div>
                                        <div class="text-center">
                                            <p class="font-bold text-gray-900 text-lg">{{ $room->room_number }}</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ $room->roomCategory->name }}</p>
                                            <p class="text-xs font-medium {{ $statusTextColors[$room->status] }} mt-1 uppercase">{{ $room->status }}</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Hover Tooltip --}}
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-10">
                                        <div class="bg-gray-900 text-white text-xs rounded-lg py-2 px-3 shadow-xl whitespace-nowrap">
                                            <p class="font-semibold">Room {{ $room->room_number }}</p>
                                            <p class="text-gray-300">{{ $room->roomCategory->name }}</p>
                                            <p class="text-gray-300">Capacity: {{ $room->roomCategory->capacity }}</p>
                                            <p class="text-gray-300">₹{{ number_format($room->roomCategory->base_tariff, 0) }}/night</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 rounded-lg p-12 text-center border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <p class="text-gray-500 font-medium">{{ trans_db('no_building_selected') }}</p>
            <p class="text-gray-400 text-sm mt-1">{{ trans_db('select_building_hint') }}</p>
        </div>
    @endif

    {{-- Legend --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h4 class="text-sm font-semibold text-gray-900 mb-3">{{ trans_db('status_legend') }}</h4>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-green-500 rounded"></div>
                <span class="text-sm text-gray-600">Available</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-red-500 rounded"></div>
                <span class="text-sm text-gray-600">Occupied</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-amber-500 rounded"></div>
                <span class="text-sm text-gray-600">Maintenance</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-blue-500 rounded"></div>
                <span class="text-sm text-gray-600">Cleaning/Buffer</span>
            </div>
        </div>
    </div>
</div>
