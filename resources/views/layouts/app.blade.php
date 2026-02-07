<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dharamshala Management' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
    @livewireStyles
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: false, desktopSidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-gray-200 transform transition-all duration-300 lg:static lg:inset-0 flex flex-col"
            :class="{
                'w-64': desktopSidebarOpen,
                'w-20': !desktopSidebarOpen,
                'translate-x-0': sidebarOpen,
                '-translate-x-full': !sidebarOpen && !window.innerWidth >= 1024,
                'lg:translate-x-0': true
            }" x-cloak>

            {{-- Logo --}}
            <div class="flex items-center h-16 border-b border-gray-200 transition-all duration-300"
                :class="desktopSidebarOpen ? 'px-6 justify-between' : 'px-0 justify-center'">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900 transition-all duration-300 whitespace-nowrap"
                        :class="desktopSidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">Dharamshala</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar"
                :class="!desktopSidebarOpen ? 'px-2' : 'px-4'">
                <a href="/admin/test"
                    class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition group"
                    :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Dashboard">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Dashboard</span>
                </a>

                <a href="{{ route('booking.counter') }}"
                    class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition group"
                    :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Counter Booking">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Counter
                        Booking</span>
                </a>

                <a href="{{ route('rooms.map') }}"
                    class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition group"
                    :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Room Map">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Room
                        Map</span>
                </a>

                <a href="{{ route('cash.ledger') }}"
                    class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition group"
                    :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Cash Ledger">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Cash
                        Ledger</span>
                </a>

                <a href="{{ route('collection.reports') }}"
                    class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition group"
                    :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Reports">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Reports</span>
                </a>

                {{-- Operations Section --}}
                <div class="pt-4 mt-4 border-t border-gray-200" x-data="{ open: true }">
                    <button @click="open = !open; if(!desktopSidebarOpen) { desktopSidebarOpen = true; open = true }"
                        class="w-full flex items-center mb-2 group focus:outline-none transition-all duration-300"
                        :class="desktopSidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider transition-all duration-300 whitespace-nowrap"
                            :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">
                            Operations & Staff</p>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transform transition-transform duration-200"
                            :class="{'rotate-180': open, 'hidden': !desktopSidebarOpen}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                        <div x-show="!desktopSidebarOpen" class="w-4 h-1 bg-gray-200 rounded-full"></div>
                    </button>

                    <div x-show="open || !desktopSidebarOpen" x-collapse>
                        <a href="{{ route('admin.staff') }}"
                            class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Staff Management">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Staff
                                Management</span>
                        </a>

                        <a href="{{ route('admin.attendance') }}"
                            class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Attendance Scanner">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Attendance
                                Scanner</span>
                        </a>

                        <a href="{{ route('admin.maintenance') }}"
                            class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Maintenance Log">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Maintenance
                                Log</span>
                        </a>

                        <a href="{{ route('expenses') }}"
                            class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Expense Tracker">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Expense
                                Tracker</span>
                        </a>

                        <a href="{{ route('forecast') }}"
                            class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="AI Forecast">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">AI
                                Forecast</span>
                        </a>
                    </div>
                </div>

                {{-- Settings Section --}}
                <div class="pt-4 mt-4 border-t border-gray-200" x-data="{ open: true }">
                    <button @click="open = !open; if(!desktopSidebarOpen) { desktopSidebarOpen = true; open = true }"
                        class="w-full flex items-center mb-2 group focus:outline-none transition-all duration-300"
                        :class="desktopSidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider transition-all duration-300 whitespace-nowrap"
                            :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">
                            Settings</p>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transform transition-transform duration-200"
                            :class="{'rotate-180': open, 'hidden': !desktopSidebarOpen}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                        <div x-show="!desktopSidebarOpen" class="w-4 h-1 bg-gray-200 rounded-full"></div>
                    </button>

                    <div x-show="open || !desktopSidebarOpen" x-collapse>
                        <a href="/admin/settings"
                            class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Website Settings">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Website
                                Settings</span>
                        </a>

                        <a href="/book"
                            class="flex items-center h-11 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Online Booking">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Online
                                Booking</span>
                        </a>

                        <a href="{{ route('logout') }}"
                            class="flex items-center h-11 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition"
                            :class="desktopSidebarOpen ? 'px-4' : 'justify-center'" title="Logout">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">Logout</span>
                        </a>
                    </div>
                </div>
            </nav>

            {{-- User Profile --}}
            <div class="p-4 border-t border-gray-200 bg-gray-50 bg-opacity-50 transition-all duration-300"
                :class="desktopSidebarOpen ? 'px-4' : 'px-0 justify-center'">
                <div class="flex items-center space-x-3 overflow-hidden"
                    :class="!desktopSidebarOpen && 'justify-center space-x-0'">
                    <div
                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 font-bold text-blue-600 border border-blue-200">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0 transition-all duration-300"
                        :class="desktopSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 overflow-hidden'">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->mobile_number }}</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Overlay for mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden" style="display: none;"></div>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Header --}}
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 lg:px-8">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    {{-- Desktop Sidebar Toggle --}}
                    <button @click="desktopSidebarOpen = !desktopSidebarOpen"
                        class="hidden lg:flex text-gray-500 hover:text-blue-600 mr-4 focus:outline-none transition-colors">
                        <svg class="w-6 h-6 transition-transform duration-300"
                            :class="{'rotate-180': !desktopSidebarOpen}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <h1 class="text-xl font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
                </div>

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false"
                        class="flex items-center space-x-3 focus:outline-none">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-white shadow-sm font-bold text-blue-600">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-900 leading-none">
                                {{ auth()->user()->name ?? 'User' }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ ucfirst(auth()->user()->role ?? 'Staff') }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                        style="display: none;">
                        <a href="/admin/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile
                            Settings</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('logout') }}"
                            class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Logout</a>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
        document.addEventListener('livewire:navigated', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
        // Handle Livewire updates
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', (el, component) => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    </script>
</body>

</html>